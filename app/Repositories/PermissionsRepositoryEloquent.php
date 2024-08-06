<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PermissionsRepository;
use App\Models\Permissions;
use App\Validators\PermissionsValidator;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;

class PermissionsRepositoryEloquent extends BaseRepository implements PermissionsRepository
{
    use StandardRepo;

    public function model() {
        return Permissions::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new Permissions;
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
            $data->slug = $request['slug']; 
            $data->description = H_handleRequest($request, 'description');


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
