<?php

namespace App\Repositories;

use Laravel\Lumen\Application;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MerchantMenuRepository;
use App\Models\MerchantMenu;
use App\Validators\MerchantMenuValidator;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;

class MerchantMenuRepositoryEloquent extends BaseRepository implements MerchantMenuRepository
{
    use StandardRepo;

    public function model() {
        return MerchantMenu::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new MerchantMenu;
        if (!empty($id)) $model = $this->model->where($this->model->getKeyName(), $id)->first();
        return $model;
    }

    public function store($raw_request, $id = null, $customRequest = null) {
        try {
 
            if ($customRequest === null) $request = $raw_request->all();
            else $request = $customRequest;

            $data = $this->initModel($id);

            //storing defined property    
            $data->merchant_id = $request['merchant_id']; 
            $data->nama = $request['nama']; 
            $data->deskripsi = $request['deskripsi']; 
            $data->foto = $request['foto']; 
            $data->harga = $request['harga']; 
            $data->created_by = H_handleRequest($request, 'created_by'); 
            $data->updated_by = H_handleRequest($request, 'updated_by'); 
            $data->deleted_by = H_handleRequest($request, 'deleted_by'); 


            if ($id) $data->updated_by = Auth::user()->id; 
            else $data->created_by = Auth::user()->id; 
    
            $data->save();
            return $data;

        } catch (Exception $e){ 
            throw new Exception($e->getMessage());
        } 
    }

    // add your customize function

}
