<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Product extends Model
{
    use Auditable;

    protected $primaryKey = 'p_id';

    protected $fillable = ['title', 'price', 'description'];
}