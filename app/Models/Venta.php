<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['fecha_venta', 'total', 'estado', 'usuario_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalleventas()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');  // Asegúrate de que 'venta_id' es la clave foránea correcta
    }

}
