<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = "items";
    protected $primaryKey = "id";
    protected $fillable = ['image', 'nombre', 'area_id', 'estado', 'qr_code', 'descripcion', 'codigo'];

    public function area()
    {
      return $this->belongsTo(Area::class);
    }
}
