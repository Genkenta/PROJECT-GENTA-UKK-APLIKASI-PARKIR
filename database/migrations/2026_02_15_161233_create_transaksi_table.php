transaksi

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
        Schema::create('tb_transaksi', function (Blueprint $table) {
    $table->increments('id_parkir');

    $table->unsignedInteger('id_kendaraan');
    $table->unsignedInteger('id_tarif');
    $table->unsignedInteger('id_user');
    $table->unsignedInteger('id_area');

    $table->dateTime('waktu_masuk');
    $table->dateTime('waktu_keluar')->nullable();

    $table->integer('durasi_jam')->nullable();
    $table->decimal('biaya_total', 10, 0)->nullable();

    $table->enum('status', ['masuk', 'keluar'])->default('masuk');

    $table->timestamps();

    // FOREIGN KEY MANUAL
    $table->foreign('id_kendaraan')
          ->references('id_kendaraan')
          ->on('tb_kendaraan')
          ->cascadeOnDelete()
          ->cascadeOnUpdate();

    $table->foreign('id_tarif')
          ->references('id_tarif')
          ->on('tb_tarif')
          ->cascadeOnDelete()
          ->cascadeOnUpdate();

    $table->foreign('id_user')
          ->references('id_user')
          ->on('tb_user')
          ->cascadeOnDelete()
          ->cascadeOnUpdate();

    $table->foreign('id_area')
          ->references('id_area')
          ->on('tb_area_parkir')
          ->cascadeOnDelete()
          ->cascadeOnUpdate();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaksi');
    }
};
 



