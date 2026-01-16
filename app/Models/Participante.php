<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $fillable = ['id_usuario', 'id_curso'];

    // Relação com o modelo Usuario (1-N)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

     // Relação com o modelo Curso (1-N)
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }
}
