<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoresHasLibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autores_has_libros', function (Blueprint $table) {
            $table->unsignedInteger("autores_id");
            $table->unsignedInteger("libros_isbn");
            $table->foreign("autores_id")->references("id")->on("autores");
            $table->foreign("libros_isbn")->references("isbn")->on("libros");
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
        Schema::dropIfExists('autores_has_libros');
    }
}
