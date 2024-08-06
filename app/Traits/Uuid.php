<?php
namespace App\Traits;

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Auth;
use Schema;
trait Uuid
{
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            try {
                $model->id = Generator::uuid4()->toString();
                // if(Auth::check()){
                //     $model->created_by = Auth::User()->id;
                // }
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });

        // static::updating(function ($model) {
        //     try{
        //         if(Auth::check()){
        //             $model->updated_by = Auth::user()->uuid;
        //         }
        //     }catch (UnsatisfiedDependencyException $e) {
        //         abort(500, $e->getMessage());
        //     }
        // });
    }
}