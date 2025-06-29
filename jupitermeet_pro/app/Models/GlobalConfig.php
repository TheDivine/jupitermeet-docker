<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalConfig extends Model
{
    use HasFactory;

    //overwrite default table name
    protected $table = 'settings';

    protected $fillable = ['key', 'value', 'description'];
}
