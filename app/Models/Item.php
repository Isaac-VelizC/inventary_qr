<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = "items";
    protected $primaryKey = "id";
    protected $fillable = ['tipo_id', 'image', 'nombre', 'area_id', 'estado', 'qr_code', 'descripcion', 'codigo', 'fecha_compra', 'fecha_baja', 'user_baja'];

    public function area()
    {
      return $this->belongsTo(Area::class);
    }
}
