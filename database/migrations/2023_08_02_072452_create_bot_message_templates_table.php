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
        Schema::create('bot_message_templates', function (Blueprint $table) {
            $table->id();            
            $table->string('name');
            $table->string('header')->nullable();
            $table->text('body')->nullable();
            $table->string('url')->nullable();
            $table->integer('frequency')->default(1);
            $table->boolean('is_active')->default(true);
            $table->integer('users_count')->default(0);
            $table->integer('hotels_count')->default(0);
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
        Schema::dropIfExists('bot_message_templates');
    }
};
