<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id');
            $table->integer('category_id');
            $table->string('judul', 100);
            $table->string('gambar', 200);
            $table->string('ajakan', 200);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('no_rekening', 45);
            $table->integer('target_donasi');
            $table->integer('terkumpul');
            $table->text('deskripsi');
            $table->tinyInteger('isPublished')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
