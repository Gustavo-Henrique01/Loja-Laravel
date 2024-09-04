<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'valor',
        'quantidade',
        'descricao',
        'imagem',
        'user_id',
    ];

    /**
     * Relacionamento com usuário (administrador).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com pedidos (muitos para muitos).
     */
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_produto', 'produto_id', 'pedido_id')
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }
}
