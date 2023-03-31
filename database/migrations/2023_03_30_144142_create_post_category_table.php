<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('post_category', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_posts_id');
            $table->unsignedBigInteger('blog_categories_id');
            $table->timestamps();
            $table->foreign('blog_posts_id')
                ->references('id')
                ->on('blog_posts')
                ->onDelete('cascade');
            $table->foreign('blog_categories_id')
                ->references('id')
                ->on('blog_categories')
                ->onDelete('cascade');
            $table->primary(['blog_posts_id', 'blog_categories_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_category');
    }
}
