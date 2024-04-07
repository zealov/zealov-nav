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
        Schema::create('system_config', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 200)->nullable()->comment('标题');
            $table->string('key', 200)->nullable()->unique('blog_config_key')->comment('键');
            $table->longText('value')->nullable()->comment('值');
            $table->string('type', 100)->nullable()->comment('类型');
            $table->string('group', 255)->nullable();
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
        Schema::dropIfExists('system_config');
    }
};
