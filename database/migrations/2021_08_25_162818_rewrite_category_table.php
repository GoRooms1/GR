<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RewriteCategoryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {

    Category::truncate();

    Schema::table('categories', function (Blueprint $table) {
      $table->dropForeign(['hotel_id']);
      $table->dropColumn(['description', 'hotel_id']);

      $table->foreignId('room_id')
        ->after('name')
        ->constrained()
        ->onDelete('cascade')
        ->onUpdate('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('categories', function (Blueprint $table) {
      $table->dropColumn(['room_id']);

      $table->text('description')
        ->nullable()
        ->after('name');
      $table->foreignId('hotel_id')
        ->after('description')
        ->constrained()
        ->onDelete('cascade')
        ->onUpdate('cascade');
    });
  }
}
