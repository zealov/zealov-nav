<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable()->comment('名称');
            $table->string('label', 100)->nullable()->comment('标识');
            $table->integer('parent_id')->nullable()->default(0)->comment('上级导航');
            $table->text('description')->nullable()->comment('路径');
            $table->string('image_path', 300)->nullable()->comment('图片地址');
            $table->tinyInteger('published')->nullable()->default(1)->comment('是否发布 1发布 2未发布');
            $table->integer('sort')->nullable()->default(1)->comment('排序');
            $table->dateTime('deleted_at')->nullable()->comment('删除');
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
        Schema::dropIfExists('categories');
    }
};