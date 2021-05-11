<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model {
    use HasFactory;

    protected $table = 'peoples';
    protected $guarded = [];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
