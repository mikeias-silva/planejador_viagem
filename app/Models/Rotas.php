<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rotas extends Model
{
    use HasFactory;

    protected $table = 'rotas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nome_trajeto',
        'data_viagem',
        'partida_nome',
        'partida_endereco',
        'partida_longitude',
        'partida_latitude',
        'destino_nome',
        'destino_endereco',
        'destino_longitude',
        'destino_latitude',
        'itinerario','user_id'];
    protected $hidden = ['user_id'];
    public $timestamps = true;


}
