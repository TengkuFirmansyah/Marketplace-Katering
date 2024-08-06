<?php

namespace App\Traits;

use App\Models\User;

trait RelationActionBy {
    public function createdByUser() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedByUser() {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
