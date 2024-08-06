<?php

namespace App\Models;

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
 * @property string $number 
 * @property string $name 
 * @property string $description 
 * @property string $multidevice 
 * @property string $status 
 * @property uuid $created_by 
 * @property uuid $updated_by 
 * @property uuid $deleted_by 

 */
class JobStatus extends Model
{
    use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes; 

    /**
     * Table Configuration
     * @var string
     */
    protected $table = 'job_status';
    protected $primaryKey = 'id';

    /**
     * List of allowed column to insert / update 
     * @var array
     */
    protected $fillable = [
        "nama",
        "description",
        "status",
        "is_read",
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

        ];
    }

}        
        