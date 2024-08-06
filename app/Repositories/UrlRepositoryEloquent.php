<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UrlRepository;
use App\Models\Url;
use App\Models\Permissions;
use App\Validators\UrlValidator;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;

class UrlRepositoryEloquent extends BaseRepository implements UrlRepository
{
    use StandardRepo;

    public function model() {
        return Url::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new Url;
        if (!empty($id)) $model = $this->model->where($this->model->getKeyName(), $id)->first();
        return $model;
    }

    public function store($raw_request, $id = null, $customRequest = null) {
        try {
 
            if ($customRequest === null) $request = $raw_request->all();
            else $request = $customRequest;

            $data = $this->initModel($id);
            //storing defined property    
            $data->parent_id = $request['parent_id']; 
            $data->name = $request['name']; 
            $data->slug = $request['slug']; 
            $data->path = $request['path']; 
            $data->icon = H_handleRequest($request, 'icon'); 
            $data->order = $request['order'];

            if ($id) $data->updated_by = Auth::user()->id; 
            else $data->created_by = Auth::user()->id; 
    
            $data->save();
            return $data;

        } catch (Exception $e){ 
            throw new Exception($e->getMessage());
        } 
    }

    public function permission($raw_request, $id = null) {
        try {
            $url = Url::where('id',$id)->first();
            $permissions = array('create','update','view','delete','restore');

            foreach($permissions as $val) {
                $data = new Permissions();
                $data->name = ucwords($url->name.' '.$val);
                $data->slug = $url->slug.'-'.$val; 
                $data->description = "";
                $data->created_by = Auth::user()->id;
                $data->save();
            }
            return $url;
        } catch (Exception $e){ 
            throw new Exception($e->getMessage());
        } 
    }
    // add your customize function

}
