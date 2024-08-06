<?php

namespace App\Repositories;

use App\Models\OrderDetails;
use Laravel\Lumen\Application;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrdersRepository;
use App\Models\Orders;
use App\Validators\OrdersValidator;
use Exception, Auth;

use App\Providers\HelperProvider;

use App\Traits\StandardRepo;

class OrdersRepositoryEloquent extends BaseRepository implements OrdersRepository
{
    use StandardRepo;

    public function model() {
        return Orders::class;
    }

    /**
     * Model initiate
     * @return object
     */
    public function initModel($id = null) {
        $model = new Orders;
        if (!empty($id)) $model = $this->model->where($this->model->getKeyName(), $id)->first();
        return $model;
    }

    public function store($raw_request, $id = null, $customRequest = null) {
        try {
 
            if ($customRequest === null) $request = $raw_request->all();
            else $request = $customRequest;
            $data = $this->initModel($id);

            //storing defined property    
            $data->merchant_id = $request['data'][0]['merchant_id'];
            $data->customer_id = Auth::user()->id;
            $data->kode = generateRandomCode();
            $data->tanggal = date('Y-m-d'); 
            $data->created_by = H_handleRequest($request, 'created_by'); 
            $data->updated_by = H_handleRequest($request, 'updated_by'); 
            $data->deleted_by = H_handleRequest($request, 'deleted_by'); 

            if ($id) $data->updated_by = Auth::user()->id; 
            else $data->created_by = Auth::user()->id; 
    
            $data->save();

            foreach($request['data'] as $key => $val){
                if($val['qty'] > 0){
                    $details = new OrderDetails();
                    $details->order_id = $data->id;
                    $details->merchant_menu_id = $val['id'];
                    $details->qty = $val['qty'];
                    $details->harga = $val['harga'];
                    $details->save();
                }
            }

            return $data;

        } catch (Exception $e){ 
            throw new Exception($e->getMessage());
        } 
    }

    // add your customize function

}
