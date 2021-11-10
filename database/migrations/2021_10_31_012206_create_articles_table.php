<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('rubric_id')->nullable();
            $table->text('slug')->nullable();
            $table->string('title');
            $table->string('description');
            $table->text('content')->nullable();
            $table->boolean('is_long_read')->default(false);
            $table->timestamp('posted_at')->nullable();
            $table->string('read_time')->nullable();
            $table->string('photography')->nullable();
            $table->integer('views')->default(0);
            $table->json('staff')->nullable();
            $table->text('preview_image_big_url')->nullable();
            $table->text('preview_image_small_url')->nullable();
            $table->boolean('is_favourite')->default(false);
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onDelete('cascade');

            $table->foreign('rubric_id')
                ->references('id')
                ->on('rubrics')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
