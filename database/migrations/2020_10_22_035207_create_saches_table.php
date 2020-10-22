<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sach', function (Blueprint $table) {
            $table->id();
            $table->string('TenSach');
            $table->string('MoTa');
            $table->string('NamXb');
            $table->string('Anh');
            $table->integer('SoLuong');
            $table->bigInteger('IdTacGia')->unsigned();
            $table->bigInteger('IdTheLoai')->unsigned();

            $table->foreign('IdTacGia')->references('id')->on('tacgia');
            $table->foreign('IdTheLoai')->references('id')->on('theloai');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sach');
    }
}
