<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nombre de la alerta (ej: "Camiones Mercedes")
            $table->string('type')->nullable(); // tipo de vehículo
            $table->string('brand')->nullable(); // marca
            $table->decimal('min_price', 12, 2)->nullable();
            $table->decimal('max_price', 12, 2)->nullable();
            $table->integer('year_from')->nullable();
            $table->integer('year_to')->nullable();
            $table->string('keyword')->nullable(); // palabra clave
            $table->string('frequency')->default('daily'); // daily, weekly
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alerts');
    }
};