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
        Schema::table('reviews', function (Blueprint $table) {           
            $table->string('book_number')->nullable();
            $table->string('city')->nullable()->change();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
           $table->dropColumn(['book_number', 'room_id']);
        });
    }
};
