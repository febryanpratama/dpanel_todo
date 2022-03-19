<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    use HasFactory;
    protected $fillable = [
        'todo', 'is_done', 'deleted_at', 'created_at', 'updated_at'
    ];
}
