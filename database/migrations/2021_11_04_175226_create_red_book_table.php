<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('red_book', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_latin')->nullable();
            $table->string('domain')->nullable();
            $table->string('type')->nullable();
            $table->string('class')->nullable();
            $table->string('squad')->nullable();
            $table->string('family')->nullable();
            $table->string('genus')->nullable();
            $table->string('kind')->nullable();
            $table->text('content')->nullable();
            $table->json('status')->nullable();
            $table->json('facts')->nullable();
            $table->text('preview_image_url')->nullable();
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
        Schema::dropIfExists('red_book');
    }
}
