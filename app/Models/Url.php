<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\RelationActionBy;


/**
 * @property uuid $id 
 * @property uuid $parent_id 
 * @property string $name 
 * @property string $url 
 * @property text $icon 
 * @property integer $order 
 * @property string $position 
 * @property uuid $created_by 
 * @property uuid $updated_by 
 * @property uuid $deleted_by 

 */
class Url extends Model
{
    use Authenticatable, HasFactory;
    use SoftDeletes, RelationActionBy, Uuid; 

    /**
     * Table Configuration
     * @var string
     */
    protected $table = 'url';
    protected $primaryKey = 'id';

    /**
     * List of allowed column to insert / update 
     * @var array
     */
    protected $fillable = [
        'parent_id', 
        'name', 
        'slug', 
        'icon', 
        'order', 
        'path', 
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
            'parent' => (new self)->Columns(),
        ];
    }

    public function children()
    {   
        return $this->hasMany(self::class,'parent_id')->orderBy('order','asc')
                ->select('url.id','url.parent_id','url.name','url.slug','url.icon','url.path','order')
                ->join('role_menus','role_menus.url_id','url.id')
                ->join('users','users.role_id','role_menus.role_id')
                ->where('users.id', Auth::user()->id);
    }

    public function parent()
    {   
        return $this->belongsTo(self::class,'parent_id');
    }
}        
        