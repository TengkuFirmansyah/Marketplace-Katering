<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use App\Providers\HelperProvider;
use App\Providers\AuthProvider;
use App\Http\Controllers\Controller;
use App\Repositories\RolesRepository;
use App\Exports\ExportFromArray;

use App\Models\Url;
use App\Models\UrlAccess;
use App\Models\Permissions;
use App\Models\RolePermissions;
use Illuminate\Support\Facades\Auth;

use Exception, Validator;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $repository;

    public function __construct(
        RolesRepository $repository
    ){
        $this->repository = $repository;

        $this->middleware('permission:settings-roles-view',['only' => ['index','findById']]);
        $this->middleware('permission:settings-roles-update',['only' => 'store']);
        $this->middleware('permission:settings-roles-create',['only' => 'store']);
        $this->middleware('permission:settings-roles-restore',['only' => 'restore']);
        $this->middleware('permission:settings-roles-delete',['only' => 'remove']);
    }
    
    public function index(Request $request) {
        try {
            $payload = $request->all();
            $data = $this->repository->getList($request, [
                'createdByUser',
                'updatedByUser',
                'deletedByUser',
            ]);
            if (isset($payload['csv'])) return $this->exportCSV($data);
            else return H_apiResponse($data);
        } catch (Exception $e){
            return H_apiResError($e);
        }
    }

    public function findById(Request $request, $id) {
        try {
            $data = $this->repository->findAll($request, true, [
                'createdByUser',
                'updatedByUser',
                'deletedByUser',
            ])->find($id);
            return H_apiResponse($data);
        } catch (Exception $e){
            return H_apiResError($e);
        }
    }

    public function store(Request $request, $id = null) {
        DB::beginTransaction();
        try {
            $validate = $this->validateStore($request, $id);
            if($validate['result']) {
                $data = $this->repository->store($request, $id);
                DB::commit();
                $msg = 'succes saving data';
                if ($id) $msg = 'success update data';
                return H_apiResponse($data, $msg);
            } else {
                return H_apiResponse(null, $validate['message'], 400);
            }
        } catch (Exception $e){
            DB::rollback();
            return H_apiResError($e);
        }
    }

    public function restore(Request $request, $id = null) {
        DB::beginTransaction();
        try {
            $data = $this->repository->restore($request, $id);
            DB::commit();
            return H_apiResponse($data, 'Data has successfully restored');
        } catch (Exception $e){
            DB::rollback();
            return H_apiResError($e);
        }
    }

    public function remove(Request $request, $id) {
        DB::beginTransaction();
        try {
            $payload = $request->all();
            $data = $this->repository->remove($request, $id);
            DB::commit();
            $msg = 'success deleted data';
            if(isset($payload['permanent'])) $msg = $msg . ' permanently';
            return H_apiResponse($data, $msg);
        } catch (Exception $e){
            DB::rollback();
            return H_apiResError($e);
        }
    }

    public function exportCSV($data) {
        $data = H_toArrayObject($data);
        $export = new ExportFromArray($data);

        $fileName = 'url-'.H_getCurrentDate();
        return Excel::download($export, ''.$fileName.'.csv');
    }

    // Validator
    public function validateStore($request, $id = null) {
        try {
            $result = true;
            $message = '';
            $payload = $request->all();
            
            $validator = Validator::make( $payload,
                [
                    'name' => 'required',

                ],
                [
                    'name.required' => 'name is required',
                ]
            );
            if ($validator->fails()) {
                $message = $validator->messages()->first();
                $result = false;
            }

            if ($id != null && empty($this->repository->findById($request, $id))) {
                $message = 'Data not found';
                $result = false;
            }

            return [
                'result' => $result,
                'message' => $message,
            ];
        } catch (Exception $e){
            if(env('APP_DEBUG')) return H_apiResError($e);
            else {
                $msg = $e->getMessage();
                return H_apiResponse(null, $msg, 400);
            }
        }
    }

    public function permission(Request $request)
    {
        $config = Permissions::select('permissions.slug')
                    ->join('role_permissions', 'role_permissions.permission_id',DB::raw('permissions.id AND role_permissions.role_id = "' . Auth::user()->role_id.'"'))
                    ->orderBy('permissions.name','asc')
                    ->get();
        return response()->json(
            [
                'message' => 'Success!!',
                'data' => $config,
            ], 200);
    }

    public function menus(Request $request)
    {
        $data = Url::select('url.id','url.parent_id','url.name','url.icon','url.path','url.order')
                        ->join('role_menus','role_menus.url_id','url.id')
                        ->where('role_menus.role_id', isset($request['role_id']) ? $request['role_id'] : Auth::user()->role_id)
                        ->whereNull('parent_id')
                        ->orderBy('order','asc')
                        ->with('children')
                        ->get();
        return response()->json(
            [
                'message' => 'Success!!',
                'data' => $data,
            ], 200);
    }
}
