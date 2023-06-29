<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->unsignedBigInteger('tipo_id')->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipos')->onDelete('cascade');
            $table->integer('estado')->default(1);
            $table->text('razon')->nullable();
            $table->string('image')->nullable();
            $table->String('qr_code')->nullable();
            $table->String('codigo', 50);
            $table->text('descripcion', 50)->nullable();
            $table->dateTime('fecha_compra');
            $table->dateTime('fecha_baja')->nullable();
            $table->string('user_baja')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
