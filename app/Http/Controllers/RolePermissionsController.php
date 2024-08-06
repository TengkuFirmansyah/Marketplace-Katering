<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use App\Exports\ExportFromArray;
use Illuminate\Http\Request;
use App\Repositories\RolePermissionsRepository;
use App\Providers\HelperProvider;
use App\Providers\AuthProvider;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class RolePermissionsController extends Controller
{
    protected $repository;
    protected $request;

    public function __construct(
        Request $request,
        RolePermissionsRepository $repository
    ){
        $this->request = $request;
        $this->repository = $repository;
        
        // $this->middleware('permission:roles-configuration',['only' => ['index','store']]);
    }
    
    public function index(Request $request) {
        // AuthProvider::has($request, 'role-permissions-browse');
        try {
            $payload = $request->all();
            $data = $this->repository->findRoleId($request);
            if (isset($payload['csv'])) return $this->exportCSV($data);
            else return H_apiResponse($data);
        } catch (Exception $e){
            return H_apiResError($e);
        }
    }

    public function store(Request $request, $id = null) {
        DB::beginTransaction();
        try {
            $validate = $this->validateStore($request, $id);
            if($validate['result']) {
                $id = $request->role_id;
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

    // Validator
    public function validateStore($request, $id = null) {
        try {
            $result = true;
            $message = '';
            $payload = $request->all();

            $validator = Validator::make( $request->all(),
                [
                    'role_id' => 'required',  

                ],
                [
                    'role_id.required' => 'role_id is required',  

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
  
        