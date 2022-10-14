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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('book_number');
            $table->string('client_fio');
            $table->string('client_phone');
            $table->string('book_type');
            $table->text('book_comment')->nullable();
            $table->dateTime('from-date');
            $table->dateTime('to-date')->nullable();
            $table->integer('hours_count')->nullable();
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
        Schema::dropIfExists('bookings');
    }
};
