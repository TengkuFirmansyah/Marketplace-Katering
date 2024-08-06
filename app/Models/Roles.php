<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\RelationActionBy;

class Roles extends Model
{
    use Authenticatable, HasFactory;
    use SoftDeletes, RelationActionBy, Uuid; 
    
    protected $connection = 'mysql';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'created_by', 
        'updated_by', 
        'deleted_by'
    ];
    protected $keyType = 'string';

    public $incrementing = false;
    
    public function Columns() {
        return $this->fillable;
    }

    public function searchRelations() {
        return [

        ];
    }
}
