<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomInMetroTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('metros', function (Blueprint $table) {
      $table->boolean('custom')->default(false)->after('hotel_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('metros', function (Blueprint $table) {
      $table->dropColumn(['custom']);
    });
  }
}
