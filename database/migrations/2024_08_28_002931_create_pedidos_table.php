<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Administrador ou usuário que registrou o pedido
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade'); // Cliente que fez o pedido
            $table->timestamps(); // created_at (data_pedido) e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
