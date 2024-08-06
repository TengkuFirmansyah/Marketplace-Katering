<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoleMenusRepository;
use App\Models\RoleMenus;
use App\Models\Url;
use App\Validators\RoleMenusValidator;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;

class RoleMenusRepositoryEloquent extends BaseRepository implements RoleMenusRepository
{
    use StandardRepo;

    public function model() {
        return RoleMenus::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new RoleMenus;
        if (!empty($id)) $model = $this->model->where($this->model->getKeyName(), $id)->first();
        return $model;
    }

    public function store($raw_request, $id = null, $customRequest = null) {
        try {
 
            if ($customRequest === null) $request = $raw_request->all();
            else $request = $customRequest;

            // $data = $this->initModel($id);
            //storing defined property   
            $delete = RoleMenus::where('role_id', $id)->forceDelete();
            foreach ($request['data'] as $key => $val) {
                RoleMenus::create([
                    'url_id' => $val,
                    'role_id' => $id,
                    'created_by' => Auth::user()->id,
                ]);
            }
            return $delete;

        } catch (Exception $e){ 
            throw new Exception($e->getMessage());
        } 
    }

    // add your customize function

    public function findRoleId($raw_request, $customRequest = null) {
        try {
            $request = $raw_request->all();
            $data = Url::select('url.id','url.parent_id','url.name','url.slug','url.icon','url.path','url.order')
                            ->join('role_menus','role_menus.url_id','url.id')
                            ->where('role_menus.role_id', isset($request['role_id']) ? $request['role_id'] : Auth::user()->role_id)
                            ->orderBy('slug','asc')
                            ->with('children')
                            ->get();
            return $data;

        } catch (Exception $e){ 
            throw new Exception($e->getMessage());
        } 
    }
}
