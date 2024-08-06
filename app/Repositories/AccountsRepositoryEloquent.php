<?php

namespace App\Repositories;

use Laravel\Lumen\Application;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AccountsRepository;
use App\Models\User;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;
use Illuminate\Support\Facades\Hash;

class AccountsRepositoryEloquent extends BaseRepository implements AccountsRepository
{
    use StandardRepo;

    public function model() {
        return User::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new User;
        if (!empty($id)) $model = $this->model->where($this->model->getKeyName(), $id)->first();
        return $model;
    }

    public function store($raw_request, $id = null, $customRequest = null) {
        try {
 
            if ($customRequest === null) $request = $raw_request->all();
            else $request = $customRequest;

            $data = $this->initModel($id);
            //storing defined property    
            $data->name = $request['name']; 
            $data->email = $request['email'];
            $data->role_id = $request['role_id'];
            $data->role_id = $request['role_id'];
            if(isset($request['password'])){
                $data->password = Hash::make($request['password']);
            }
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
