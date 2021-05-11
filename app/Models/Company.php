<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends  Model {
    use HasFactory;

    protected $table = 'companies';
    protected $guarded = [];

    public function clients() {
        return $this->hasMany(People::class, 'company_id', 'id');
    }
}

