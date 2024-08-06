<?php

namespace App\Traits;

use Prettus\Repository\Criteria\RequestCriteria;
use Exception, Auth;

trait StandardRepo {
  
  public function columns() {
    return $this->model->Columns();
  }

  public function relation($val = null, $relationBefore) {
    $array = [];
    $searchRelations = $val->searchRelations();
    foreach ($searchRelations as $relationAfter => $cols) {
      if($cols[0]){
        foreach ($cols as $key => $col) {
          $array[] = $relationBefore.'.'.$relationAfter.'.'.$col;
        }
      } else {
        $searchColumns = $cols->Columns();
        foreach ($searchColumns as $cols1) {
          $array[] = $relationBefore.'.'.$relationAfter.'.'.$cols1;
        }
        $relationAfter = $relationBefore.'.'.$relationAfter;
        $array = array_merge($array, $this->relation($cols, $relationAfter));
      }
    }
    return $array;
  }
  
  public function validateColumns($name) {
    $columns = $this->columns();
    /* APPEND : Relation Column 
      menambahkan column yang tersedia di relation agar bisa di search 
      dan akan di append ke $columns agar lolos validasi
    */
    if(method_exists($this->model, 'searchRelations')) {
      $searchRelations = $this->model->searchRelations();
      foreach ($searchRelations as $relation => $cols) {
        if($cols[0]) {
          foreach ($cols as $key => $col) {
            $columns[] = $relation.'.'.$col;
          }
        } else {
          $searchColumns = $cols->Columns();
          foreach ($searchColumns as $cols1) {
            $columns[] = $relation.'.'.$cols1;
          }
          $columns = array_merge($columns, $this->relation($cols, $relation));
        }
      }
    }

    $valid = false;
    foreach ($columns as $col) {
      $mixCol = $col.'!'; // important / exact search
      $orCol = $col.'^'; // important / exact search
      $reqCol = $col.'@'; // important / exact search
      // for integer operator
      $gt     = $col.H_getOperatorType('gt'); // greater than
      $gte    = $col.H_getOperatorType('gte'); // greater than equals
      $lt     = $col.H_getOperatorType('lt'); // less than
      $lte    = $col.H_getOperatorType('lte'); // less than equals
      // for date operator
      $gtd     = $col.H_getOperatorType('gtd'); // greater than
      $gted    = $col.H_getOperatorType('gted'); // greater than equals
      $ltd     = $col.H_getOperatorType('ltd'); // less than
      $lted    = $col.H_getOperatorType('lted'); // less than equals
      $start   = $col.H_getOperatorType('start'); // start point
      $end     = $col.H_getOperatorType('end'); // end point
      if (
        $name == $col 
        || $name == $mixCol
        || $name == $orCol
        || $name == $reqCol
        || $name == $gt
        || $name == $gte
        || $name == $lt
        || $name == $lte
        || $name == $gtd
        || $name == $gted
        || $name == $ltd
        || $name == $lted
        || $name == $start
        || $name == $end
      ) {
        $valid = true;
        break;
      }
      else $valid = false;
    }

    // dd($valid, $columns);
    return $valid;
  }

  public function boot() {
    $this->pushCriteria(app(RequestCriteria::class));
  }

  public function totalData($raw_request) {
    $payload = $raw_request->all();
    $data = $this->model;
    if (H_hasRequest($payload, 'trash')) $data = $data->onlyTrashed();
    return $data->count();
  }

  public function findAll($raw_request, $raw = false, $relations = null) {
    try {
      $payload = $raw_request->all();
      $data = $this->model;
      if ($relations) $data = $data->with($relations);
      $data = $this->searchable($data, $payload);
      // return $data;
      if ($raw) return $data;
      else return $data->get();
    } catch (Exception $e){
      throw new Exception($e->getMessage());
    }
  }

  public function findById($raw_request, $id, $stric = false, $relations = null) {
    $payload = $raw_request->all();
    $data = $this->findAll($raw_request, true, $relations);
    $data = $data->where($this->model->getKeyName(), $id)->first();
    if ($stric) {
      if (empty($data)) throw new Exception("Data with id $id not found");
    }
    return !empty($data) ? $data : null;
  }

  public function getList($raw_request, $relations = null, $countRelations = null) {
    try {
      $payload = $raw_request->all();
      if(isset($payload['with'])) {
        if($payload['with'] == "null") {
          $relations = null;
        }
      }
      $data = $this->findAll($raw_request, true);
      // return $data;
      if ($relations) $data = $data->with($relations);
      if ($countRelations) $data = $data->withCount($countRelations);
      
      $limit = env('PAGINATION_LIMIT', 5);
      if (H_hasRequest($payload, 'limit') && $payload['limit'] != '0') $limit = $payload['limit'];
      if (isset($payload['table'])) return $data->paginate($limit)->withQueryString();
      else {
        if (H_hasRequest($payload, 'limit') && $payload['limit'] == '0') return $data->get();
        else return $data->limit($limit)->get();
      }
    } catch (Exception $e){
      throw new Exception($e->getMessage());
    }
  }

  public function remove($raw_request, $id) {
    try {
      $request = $raw_request->all();
      $data = $this->model->where($this->model->getKeyName(), $id);

      if(isset($request['permanent'])) {
        if ($data->first() == null) $data = $data->onlyTrashed();
      }
      $data = $data->first();

      if ($data) {
        if(isset($request['permanent'])) $data->forceDelete();
        else {
          if (in_array("deleted_by", $this->columns())) {
            $data->deleted_by = Auth::user()->id;
            $data->save();
          }

          $delete = $data->delete();

          if (get_class($this) === 'ActivityRepository') {
            // untuk handle agar tidak recursive
          } elseif (isset($this->log)) {
            $this->log->make($data, 'd');
          }

        }

        return $data;
      } else {
        return null;
      }

    } catch (Exception $e){
      throw new Exception($e->getMessage());
    }
  }

  public function restore($raw_request, $id) {
    try {
      $request = $raw_request->all();
      $data = $this->model->whereId($id)->onlyTrashed()->first();
      if ($data) {
        if (in_array("updated_by", $this->columns())) {
          $data->updated_by = Auth::user()->id;
          $data->deleted_by = null;
        }

        $restore = $data->restore();

        if (get_class($this) === 'ActivityRepository') {
          // untuk handle agar tidak recursive
        } elseif (isset($this->log)) {
          $this->log->make($data, 'r');
        }
        return $restore;
      } else return null;

    } catch (Exception $e){
        throw new Exception($e->getMessage());
    }
  }

  public function dynamicList($raw_data, $payload) {
    try {
      $limit = env('PAGINATION_LIMIT', 5);
      if (H_hasRequest($payload, 'limit') && $payload['limit'] != '0') $limit = $payload['limit'];

      if (isset($payload['table'])) return $raw_data->paginate($limit)->withQueryString();
          else {
            if (H_hasRequest($payload, 'limit') && $payload['limit'] == '0') return $raw_data->get();
            else return $raw_data->limit($limit)->get();
          }
    } catch (Exception $e){
      throw new Exception($e->getMessage());
    }
  }

  public function logger($data, $id, $type = null) {
      // logging injection
      $mode = ($id) ? 'u' : 'c';
      // log mode, name & description akan di overide jika log_type ada
      $data->log_type = $type; 
      $this->log->make($data, $mode);
  }

  /* Searchable Query Extend 
    allow query search, order & group in url params
    @$data                : model instance
    @$payload             : Raw Request instance  with scope ->all();

    [Search] :
    - like                : ?search=column:value
    - exact/equal         : seach=column!:value

    # greater, less with equal integer ----------------
    - greater than        : ?search=column@gt:integerValue
    - greater than equal  : ?search=column@gte:integerValue
    - less than           : ?search=column@lt:integerValue
    - less than equal     : ?search=column@lte:integerValue

    # greater, less with equal date/dateTime format ----------------
    - greater than        : ?search=column@gtd:dateValue 
    - greater than equal  : ?search=column@gted:dateValue
    - less than           : ?search=column@ltd:dateValue 
    - less than equal     : ?search=column@lted:dateValue 

    # date start & end point
    - start               : ?search=column@start:dateValue 
    - end                 : ?search=column@end:dateValue 

    [Order] :
    - ASCENDING           : ?order=column:asc
    - DESCENDING          : ?order=column:desc

    [Group] :
    - default             : ?group=column1|column2ifNeed

    [Misc] :
    - deleted             : ?trash
    - active & deleted    : ?all

    [Rules] :
    # search with relation
    ?search=relationModel.columName=value
    ! makesure relation has mapped in model, in function searchRelations, ex :
      `public function searchRelations() {
          return [
              'relationName' => (new ModelName())->Columns(),
          ];
      }`
    ! if function not define, please define that function bellow function Columns()

  */
  public function searchable($data, $payload, $primaryTable = null) {
    try {
      if (H_hasRequest($payload, 'trash')) $data = $data->onlyTrashed();
      if (H_hasRequest($payload, 'all')) $data = $data->withTrashed();

      $primaryTable = ($primaryTable) ? $primaryTable.'.' : null;
      
      $search = [];
      if (isset($payload['search'])) $search = H_extractParamsAttribute($payload['search']);
      
      $searchLike = null;
      if (isset($payload['search_like'])) $searchLike = H_extractParamLike($payload['search_like']);
      
      $filter = [];
      if (isset($payload['filter'])) $filter = H_extractParamsAttribute($payload['filter']);

      $order = [];
      if (isset($payload['order'])) $order = H_extractParamsAttribute($payload['order']);

      $group = [];
      if (isset($payload['group'])) $group = H_extractSingleParamsAttribute($payload['group']);
      if (count($search) != 0) { // filter search
        foreach ($search as $key => $params) {
          if ($this->validateColumns($params['key'])) {
            $key = H_escapeStringTable($params['key']);
            // return $key;
            // $value = H_escapeString($params['value']); // menghilangkan strip pada pencarian
            $value = $params['value'];
            $importantCheck = explode('!', $key);
            $orCheck = explode('^', $key);
            $required = explode('@', $key);
            
            $column = $primaryTable . H_getColumSearch($key);
            $operator = H_getOperatorSearch($key);
            
            $relField = H_extractKeyRelation($key);
            if ($relField) { // relation search
              if(isset($orCheck[1])){
                $data = $data->orWhereHas($relField['relation'], function ($q) use ($relField, $key, $value, $importantCheck, $operator, $primaryTable) {
                  // querying
                  $column = str_replace('^','',$primaryTable . $relField['column']);
                  $column = str_replace('@','',$column);
                    if ($operator) {
                      $value = H_getValueForOperator($key, $value);
                      $q->whereRaw("$column $operator ?", [$value]);
                    } else {
                      if ($value == 'not_null') $q->whereNotNull($column);
                      else if ($value == 'is_null') $q->whereNull($column);
                      else if (isset($importantCheck[1])) $q->whereRaw(''.$column.' = ? ', [$value]); // jika menggunakan [!]
                      else if (isset($required[1])) $q->where($column.'=', $value); // jika menggunakan [@]
                      else $q->whereRaw(''.$column.' like ?', ['%'.$value.'%']);
                    }
                    
                  });
              } else {
                $data = $data->whereHas($relField['relation'], function ($q) use ($relField, $key, $value, $importantCheck, $operator, $primaryTable) {
                  // querying
                  $column = $primaryTable . $relField['column'];
                  $column = str_replace('@','',$column);
                    if ($operator) {
                      $value = H_getValueForOperator($key, $value);
                      $q->whereRaw("$column $operator ?", [$value]);
                    } else {
                      if ($value == 'not_null') $q->whereNotNull($column);
                      else if ($value == 'is_null') $q->whereNull($column);
                      else if (isset($importantCheck[1])) $q->whereRaw(''.$column.' = ? ', [$value]); // jika menggunakan [!]
                      else if (isset($required[1])) $q->where(''.$column.' = ', $value); // jika menggunakan [@]
                      else $q->whereRaw(''.$column.' like ?', ['%'.$value.'%']);
                    }
                    
                  });
              }

            } else { // default search

              if ($operator) {
                $value = H_getValueForOperator($key, $value);
                $data = $data->whereRaw("$column $operator ?", [$value]);
              } else {
                $column = str_replace('@','',$column);
                if ($value == 'not_null') {
                  $data = $data->whereNotNull($column);
                } else if ($value == 'is_null') {
                  $data = $data->whereNull($column);
                } else if (isset($importantCheck[1])) {
                  $data = $data->whereRaw(''.$column.' != ? ', [$value]); // jika menggunakan [!]
                } else if (isset($orCheck[1])) {
                  $column = str_replace('^','',$column);
                  $data = $data->orWhereRaw(''.$column.' != ? ', [$value]); // jika menggunakan [^]
                }else if (isset($required[1])){
                  $data = $data->where($column,'=',$value); // jika menggunakan [@]
                } else {
                  $data = $data->whereRaw('('.$column.' = ? OR '.$column.' like ?)', [$value,'%'.$value.'%']);
                }
              }
            }

          }
        }
      }

      if ($searchLike) {
        $data = $data->where(function($q) use($searchLike) {
          $index = 0;
          foreach($searchLike->columns as $r) {
            if (in_array($r, $this->model->Columns())) {
              if ($index === 0) $q->where($r, 'LIKE', "%{$searchLike->value}%");
              else $q->orWhere($r, 'LIKE', "%{$searchLike->value}%");
              $index++;
            }
          }
        });
      }

      if (count($filter) != 0) { // filter
        foreach ($filter as $key => $params) {
            if ($this->validateColumns($params['key'])) {
                $key = H_escapeStringTable($params['key']);
                $value = H_escapeString($params['value']);

                $importantCheck = explode('!', $key);
                $column = $primaryTable . $importantCheck[0];
                $data = $data->where($column, $value);
            }
        }
      }

      if (count($order) != 0) { // order
        foreach ($order as $key => $params) {
          if ($this->validateColumns($params['key'])) {
            $key = H_escapeString($params['key']);
            $value = H_escapeString($params['value']);
            $value = strtoupper($value);
            if ($value == 'ASC' || $value == 'DESC') $data = $data->orderBy($primaryTable . $key, $value);
          }
        }
      } else {
        $createdAt = $primaryTable . 'created_at';
        $data = $data->orderBy($createdAt, 'desc');
      }

      if (count($group) != 0) { // group
        $selects = [];
        foreach ($group as $key => $params) {
          if ($this->validateColumns($params)) {
            $key = H_escapeString($params);
            $selects[] = $primaryTable . $params;
          }
          
        }
        if (count($selects) != 0) {
          $data = $data->select($selects);
          $data = $data->groupBy($selects);
        }
      }

      // return $data->getBindings();
      return $data;
    } catch (Exception $e){
      throw new Exception($e->getMessage());
    }
  }

  public function generateCode($data, $field = '', $prefix = '', $where = null) {
    try {
      $year = date('Y');
      $month = date('m');

      $department = '';
      $role = '';

      if ($data->createdByUser && $data->createdByUser->department)
        $department = $data->createdByUser->department->code;
      if ($data->createdByUser && $data->createdByUser->Role)
        $role = $data->createdByUser->Role->code;

      $qData = $this->model->query()->where('id', '<>', $data->id);
      if ($where) $qData->where($where);
      if (!empty($field)) $qData = $qData->whereNotNull($field);
      $qData = $qData->whereYear('created_at', $year)
        ->orderBy('id', 'desc')
        ->first();

      if ($qData) {
        if ($field === '' || $field === null) $code = $qData->code ? $qData->code : $qData->document_number;
        else $code = $qData->{$field};

        $ex = explode('/', $code);
        $num = (int) $ex[count($ex) - 1];
      } else $num = 0;
      $num++;
      $num = $num > 999 ? 0 : $num;
      $num = str_pad($num, 3, '0', STR_PAD_LEFT);

      $gen = [ $department, strtoupper($role), $prefix, $year, H_formatToRoman((int) $month), $num];
      return join('/', $gen);

    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function checkApproval($id, $fieldForMessage = 'code', $fieldApprove = 'approved_by', $fieldReject = 'rejected_by') {
    try {
      $data = $this->model->find($id);
      $res = ['success' => false, 'message' => ''];

      if ($data) {
        if ($data->{$fieldApprove}) $res = ['success' => true, 'message' => ($data->{$fieldForMessage} ?? 'Data').' is already approved.'];
        if ($data->{$fieldReject}) $res = ['success' => true, 'message' => ($data->{$fieldForMessage} ?? 'Data').' is already rejected.'];
      }

      return (object) $res;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function periodical ($data, $payload, $startCol = 'start_date', $endCol = 'end_date') {
    if (H_hasRequest($payload, 'from')) {
        $data = $data->where($startCol, '>=', $payload['from']);
        if (H_hasRequest($payload, 'to')) $data = $data->where($endCol, '<=',  $payload['to']); // jika ada akhir periode baru di set
    }

    return $data;
  }
}
