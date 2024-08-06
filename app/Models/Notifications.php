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
 * @property string $ref 
 * @property uuid $ref_id 
 * @property uuid $to 
 * @property uuid $for 
 * @property text $note 
 * @property uuid $created_by 
 * @property uuid $updated_by 
 * @property uuid $deleted_by 

 */
class Notifications extends Model
{
    use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes, RelationActionBy, Uuid; 

    /**
     * Table Configuration
     * @var string
     */
    protected $table = 'notifications';
    protected $primaryKey = 'id';

    /**
     * List of allowed column to insert / update 
     * @var array
     */
    protected $fillable = [
        'ref', 
        'ref_id', 
        'to', 
        'for', 
        'note', 
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
        