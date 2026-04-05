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
        Schema::create('tb_user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama_lengkap', 50);
            $table->string('username', 50)->unique();
            $table->string('password', 100);
            $table->enum('role', ['admin', 'petugas' ,'owner']);
            $table->tinyInteger('status_aktif')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
