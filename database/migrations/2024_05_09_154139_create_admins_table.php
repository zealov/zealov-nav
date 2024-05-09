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
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable()->unique()->comment('账户');
            $table->string('nick_name', 100)->nullable()->comment('昵称');
            $table->string('password', 200)->nullable()->comment('密码');
            $table->string('email', 50)->nullable()->comment('邮箱');
            $table->string('salt', 16)->nullable()->comment('盐值');
            $table->tinyInteger('status')->default(1)->comment('1启用 2禁用');
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
        Schema::dropIfExists('admins');
    }
};
