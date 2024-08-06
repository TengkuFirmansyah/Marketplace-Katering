<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use Image;
use App\Exports\ExportFromArray;
use App\Models\MerchantMenu;
use Illuminate\Http\Request;
use App\Repositories\MerchantMenuRepository;
use App\Providers\HelperProvider;
use App\Providers\AuthProvider;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class MerchantMenuController extends Controller
{
    protected $repository;
    protected $request;

    public function __construct(
        Request $request,
        MerchantMenuRepository $repository
    ){
        $this->request = $request;
        $this->repository = $repository;

        $this->middleware('permission:merchant-menu-view',['only' => ['index','findById']]);
        $this->middleware('permission:merchant-menu-update',['only' => 'store']);
        $this->middleware('permission:merchant-menu-create',['only' => 'store']);
        $this->middleware('permission:merchant-menu-restore',['only' => 'restore']);
        $this->middleware('permission:merchant-menu-delete',['only' => 'remove']);
    }
    
    public function index(Request $request) {
        try {
            $payload = $request->all();
            $data = $this->repository->getList($request, []);
            if (isset($payload['csv'])) return $this->exportCSV($data);
            else return H_apiResponse($data);
        } catch (Exception $e){
            return H_apiResError($e);
        }
    }

    public function findById(Request $request, $id) {
        try {
            $data = $this->repository->findAll($request, true, [])->find($id);
            return H_apiResponse($data);
        } catch (Exception $e){
            return H_apiResError($e);
        }
    }

    public function store(Request $request, $id = null) {
        DB::beginTransaction();
        try {
            if($request->file('file')){
                $this->validate($request, [
                    'file' => 'required|mimes:jpeg,png,jpg|max:2048',
                ]);
                $data = MerchantMenu::find($id);
                if($data) {
                    //lama
                    $path = url('/images/menu/');
                    $imageName = time().'.'.$request->file->extension();  
                    $request->file->move(public_path('/images/menu/'), $imageName);
                    $data->foto = $path.'/'.$imageName;
                    $data->save();
                }

                DB::commit();
                $msg = 'succes saving data';
                return H_apiResponse($data, $msg);
            } else {
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

        $fileName = 'merchant_menu-'.H_getCurrentDate();
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
                    'merchant_id' => 'required',  
                    'nama' => 'required',  
                    'deskripsi' => 'required',  
                    'harga' => 'required',  

                ],
                [
                    'merchant_id.required' => 'merchant_id is required',  
                    'nama.required' => 'nama is required',  
                    'deskripsi.required' => 'deskripsi is required',  
                    'harga.required' => 'harga is required',  

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
  
        