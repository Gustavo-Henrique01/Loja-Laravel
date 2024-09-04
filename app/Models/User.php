<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENTE = 'cliente';

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCliente()
    {
        return $this->role === self::ROLE_CLIENTE;
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
