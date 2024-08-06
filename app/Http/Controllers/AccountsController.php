<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use App\Exports\ExportFromArray;
use Illuminate\Http\Request;
use App\Repositories\AccountsRepository;
use App\Providers\HelperProvider;
use App\Providers\AuthProvider;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    protected $repository;
    protected $request;

    public function __construct(
        Request $request,
        AccountsRepository $repository
    ){
        $this->request = $request;
        $this->repository = $repository;

        $this->middleware('permission:settings-users-view',['only' => ['index','findById']]);
        $this->middleware('permission:settings-users-update',['only' => 'store']);
        $this->middleware('permission:settings-users-create',['only' => 'store']);
        $this->middleware('permission:settings-users-restore',['only' => 'restore']);
        $this->middleware('permission:settings-users-delete',['only' => 'remove']);
    }
    
    public function index(Request $request) {
        try {
            $payload = $request->all();
            $data = $this->repository->getList($request, [
                'role',
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

        $fileName = 'master_jadwal_test-'.H_getCurrentDate();
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
                    'role_id' => 'required',  
                    'name' => 'required', 
                    'email' => 'required',
                    'password' => 'min:8',
                    'confirm_password' => 'same:password',
                ],
                [
                    'role_id.required' => 'role is required',  
                    'name.required' => 'nama is required',  
                    'email.required' => 'email is required',
                    'password.min' => 'password must be at least 8 characters',
                    'confirm_password.same' => 'confirm password must match password',
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

}
  
        