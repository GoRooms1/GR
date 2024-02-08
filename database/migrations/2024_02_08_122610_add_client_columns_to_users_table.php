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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['m', 'f'])->nullable();
            $table->boolean('is_client')->default(false);
            $table->boolean('notify_hot')->default(false);
            $table->boolean('notify_review')->default(false);            
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
            $table->dropColumn(['gender', 'is_client', 'notify_hot', 'notify_review']);
        });
    }
};
