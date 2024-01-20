<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtratoModel extends Model
{
    protected $table = 'extrato';
    protected $primaryKey = 'id_extrato';

    use HasFactory;
}
