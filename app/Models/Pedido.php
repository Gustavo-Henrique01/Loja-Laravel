<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cliente_id',
    ];

    /**
     * Relacionamento com cliente.
     * Um pedido pertence a um cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento com usuário (administrador que registrou o pedido).
     * Um pedido pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com produtos (muitos para muitos).
     * Um pedido tem muitos produtos através da tabela `pedido_produto`.
     */
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'pedido_produtos', 'pedido_id', 'produto_id')
                    ->withPivot('id','quantidade')
                    ->withTimestamps();
    }
}
