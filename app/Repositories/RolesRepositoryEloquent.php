<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RolesRepository;
use App\Models\Roles;
use App\Validators\RolesValidator;
use Exception;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;
use Illuminate\Support\Facades\Auth;

class RolesRepositoryEloquent extends BaseRepository implements RolesRepository
{
    use StandardRepo;

    public function model() {
        return Roles::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new Roles;
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
