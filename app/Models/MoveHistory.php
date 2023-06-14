<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoveHistory extends Model
{
    use HasFactory;
    protected $table = "move_histories";
    protected $primaryKey = "id";
    protected $fillable = ['item_id', 'descripcion', 'movimiento'];

    public function elemento()
    {
      return $this->belongsTo(item::class, 'area_id');
    }
}
