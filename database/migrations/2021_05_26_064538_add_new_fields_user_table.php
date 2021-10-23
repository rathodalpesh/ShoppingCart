<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role',10)->nullable();
            $table->string('username',100)->nullable();
            $table->string('language',10)->nullable();
            $table->string('currency',10)->nullable();
            $table->boolean('status')->default(true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('username');
            $table->dropColumn('language');
            $table->dropColumn('currency');
            $table->dropColumn('status');
        });
    }
}
