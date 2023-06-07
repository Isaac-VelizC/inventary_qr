<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoveHistory extends Model
{
    use HasFactory;
    protected $table = "move_histories";
    protected $primaryKey = "id";
    protected $fillable = ['area_id', 'descripcion', 'movimiento'];
}
