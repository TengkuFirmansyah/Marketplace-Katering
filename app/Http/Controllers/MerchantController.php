<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use App\Exports\ExportFromArray;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Repositories\MerchantRepository;
use App\Providers\HelperProvider;
use App\Providers\AuthProvider;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    protected $repository;
    protected $request;

    public function __construct(
        Request $request,
        MerchantRepository $repository
    ){
        $this->request = $request;
        $this->repository = $repository;

        $this->middleware('permission:merchant-profile-view',['only' => ['index','findById','myProfile']]);
        $this->middleware('permission:merchant-profile-update',['only' => 'store']);
        $this->middleware('permission:merchant-profile-create',['only' => 'store']);
        $this->middleware('permission:merchant-profile-restore',['only' => 'restore']);
        $this->middleware('permission:merchant-profile-delete',['only' => 'remove']);
    }
    
    public function index(Request $request) {
        try {
            $payload = $request->all();
            $data = $this->repository->getList($request, [
                'menus',
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
                'menus',
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
                $data = $this->repository->store($request);
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

        $fileName = 'merchant-'.H_getCurrentDate();
        return Excel::download($export, ''.$fileName.'.csv');
    }

    // Validator
    public function validateStore($request, $id = null) {
        try {
            $result = true;
            $message = '';
            $payload = $request->all();

            $validator = Validator::make( $request->all(),
                [
                    'nama' => 'required',  
                    'alamat' => 'required',  
                    'kontak' => 'required',  
                    'deskripsi' => 'required',  

                ],
                [
                    'nama.required' => 'nama is required',  
                    'alamat.required' => 'alamat is required',  
                    'kontak.required' => 'kontak is required',  
                    'deskripsi.required' => 'deskripsi is required',  

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

    public function myProfile(Request $request)
    {
        $data = Merchant::where('user_id', Auth::user()->id)->first();
        return response()->json(
            [
                'message' => 'Success!!',
                'data' => $data,
            ], 200);
    }
}
  
        