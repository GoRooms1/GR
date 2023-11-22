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
        Schema::create('cost_periods', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('cost_id');
            $table->foreign('cost_id')
                ->references('id')
                ->on('costs')
                ->onDelete('cascade');
            $table->double('value')->default(0);
            $table->integer('discount')->nullable();
            $table->timestamp('date_from');
            $table->timestamp('date_to');         
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('cost_periods');
    }
};
