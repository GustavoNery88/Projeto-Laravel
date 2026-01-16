<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['nome', 'descricao', 'id_usuario'];

    // Relação com o modelo Usuario (1-N)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

     // Muitos para muitos (participantes)
    public function usuarios()
    {
        return $this->belongsToMany(
            Usuario::class,
            'participantes',
            'id_curso',
            'id_usuario'
        );
    }
}
