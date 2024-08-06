<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;

use App\Traits\RelationActionBy;


/**
 * @property uuid $id 
 * @property uuid $user_id 
 * @property string $nama 
 * @property string $alamat 
 * @property string $kontak 
 * @property text $deskripsi 
 * @property uuid $created_by 
 * @property uuid $updated_by 
 * @property uuid $deleted_by 

 */
class Merchant extends Model
{
    use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes, RelationActionBy, Uuid; 

    /**
     * Table Configuration
     * @var string
     */
    protected $table = 'merchant';
    protected $primaryKey = 'id';

    /**
     * List of allowed column to insert / update 
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'nama', 
        'alamat', 
        'kontak', 
        'deskripsi', 
        'created_by', 
        'updated_by', 
        'deleted_by'
    ];

    // disabled timestamps data
    public $timestamps = true;

    protected $keyType = 'string';

    public $incrementing = false;

    // disable update col id
    protected $guarded = ['id'];

    public function Columns() {
        return $this->fillable;
    }

    public function searchRelations() {
        return [
            'menus' => (new MerchantMenu())->Columns(),
        ];
    }

    function menus()
    {   
        return $this->hasMany(MerchantMenu::class,'merchant_id');
    }




}        
        