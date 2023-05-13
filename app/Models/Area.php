<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = "areas";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'estado', 'encargado', 'descripcion'];

    public function items()
    {
      return $this->hasMany(item::class);
    }
}
