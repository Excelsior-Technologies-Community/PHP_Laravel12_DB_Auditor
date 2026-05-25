<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Product extends Model
{
    use Auditable, SoftDeletes;

    protected $primaryKey = 'p_id';

    protected $fillable = [
        'title',
        'price',
        'description'
    ];
}