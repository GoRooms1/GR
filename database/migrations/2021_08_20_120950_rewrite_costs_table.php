<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Новая таблица для стоимости комнат
 */
class RewriteCostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('costs', function (Blueprint $table) {

      \App\Models\Cost::truncate();

      $table->dropColumn(['start_at', 'end_at', 'min', 'user_id', 'count', 'description']);
      $table->dropMorphs('model');
      $table->dropForeign(['type_id']);

      $table->foreignId('room_id')
        ->after('value')
        ->constrained('rooms')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('period_id')
        ->after('room_id')
        ->constrained('periods')
        ->onUpdate('cascade')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('costs', function (Blueprint $table) {
      $table->dropForeign(['room_id']);
      $table->dropForeign(['period_id']);

      $table->time('start_at')->nullable();
      $table->time('end_at')->nullable();
      $table->integer('min')->default(1);
      $table->string('count')->nullable();
      $table->nullableMorphs('model');
      $table->unsignedBigInteger('type_id');
      $table->unsignedBigInteger('user_id');
      $table->text('description')->nullable();
    });
  }
}
