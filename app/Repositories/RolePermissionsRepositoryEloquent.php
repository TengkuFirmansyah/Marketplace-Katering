<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RolePermissionsRepository;
use App\Models\RolePermissions;
use App\Validators\RolePermissionsValidator;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;

class RolePermissionsRepositoryEloquent extends BaseRepository implements RolePermissionsRepository
{
    use StandardRepo;

    public function model() {
        return RolePermissions::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new RolePermissions;
        if (!empty($id)) $model = $this->model->where($this->model->getKeyName(), $id)->first();
        return $model;
    }

    public function store($raw_request, $id = null, $customRequest = null) {
        try {
 
            if ($customRequest === null) $request = $raw_request->all();
            else $request = $customRequest;
            // $data = $this->initModel($id);

            //storing defined property    
            $delete = RolePermissions::where('role_id', $id)->forceDelete();
            foreach ($request['data'] as $key => $val) {
                RolePermissions::create([
                    'permission_id' => $val,
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
            $data = RolePermissions::where('role_id', $request['role_id'])
                            ->select(
                                'permissions.id',
                                'role_permissions.role_id',
                                'permissions.name',
                                'permissions.slug',
                            )
                            ->join('permissions','permissions.id','=','role_permissions.permission_id')
                            ->get();
            return $data;

        } catch (Exception $e){ 
            throw new Exception($e->getMessage());
        } 
    }
}
