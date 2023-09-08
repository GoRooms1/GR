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
        Schema::create('ad_banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');            
            $table->string('url')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('show_from')->nullable();
            $table->timestamp('show_to')->nullable();         
            $table->boolean('is_show_always')->default(false);
            $table->boolean('is_show_on_hotels')->default(false);
            $table->boolean('is_show_on_rooms')->default(false);
            $table->boolean('is_show_on_hotel')->default(false);
            $table->boolean('is_show_on_hot')->default(false);
            $table->json('cities')->nullable();
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
        Schema::dropIfExists('ad_banners');
    }
};
