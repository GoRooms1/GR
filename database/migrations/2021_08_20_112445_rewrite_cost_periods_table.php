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
    public function up(): void
    {
        Schema::dropIfExists('cost_periods');
//    Schema::table('cost_periods', function (Blueprint $table) {
//      $table->dropMorphs('model');
//      $table->dropForeign('cost_periods_type_id_foreign');
//      $table->dropColumn(['start_at', 'end_at', 'min', 'time', 'type_id']);

//      $table->foreignId('room_id')
//        ->constrained()
//        ->onUpdate('cascade')
//        ->onDelete('cascade');
//
//      $table->foreignId('period_id')
//        ->constrained()
//        ->onUpdate('cascade')
//        ->onDelete('cascade');

//    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
//    Schema::table('cost_periods', function (Blueprint $table) {
        ////      $table->dropForeign(['room_id', 'period_id']);
//
//      $table->time('start_at')->nullable();
//      $table->time('end_at')->nullable();
//      $table->integer('min')->nullable();
//      $table->integer('time')->default(1);
//      $table->nullableMorphs('model');
//      $table->unsignedBigInteger('type_id');
//      $table->foreign('type_id')
//        ->references('id')
//        ->on('cost_types')
//        ->onDelete('cascade');
//    });

        Schema::create('cost_periods', function (Blueprint $table) {
            $table->id();
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
            $table->integer('min')->nullable();
            $table->integer('time')->default(1);
            $table->nullableMorphs('model');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')
              ->references('id')
              ->on('cost_types')
              ->onDelete('cascade');
            $table->timestamps();
        });
    }
};
