<?php

namespace App\Repositories;

use Laravel\Lumen\Application;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MerchantRepository;
use App\Models\Merchant;
use App\Validators\MerchantValidator;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;

class MerchantRepositoryEloquent extends BaseRepository implements MerchantRepository
{
    use StandardRepo;

    public function model() {
        return Merchant::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new Merchant;
        if (!empty($id)) $model = $this->model->where($this->model->getKeyName(), $id)->first();
        return $model;
    }

    public function store($raw_request, $id = null, $customRequest = null) {
        try {
 
            if ($customRequest === null) $request = $raw_request->all();
            else $request = $customRequest;
            $data = $this->initModel($request['id']);

            //storing defined property    
            if($request['user_id'] == null) {
                $data->user_id = Auth::user()->id; 
            }
            $data->nama = $request['nama']; 
            $data->alamat = $request['alamat']; 
            $data->kontak = $request['kontak']; 
            $data->deskripsi = $request['deskripsi']; 
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
