<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSavedColumnsInHotelTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('hotels', function (Blueprint $table) {
      $table->boolean('old_moderate')->default(false)->after('route');
      $table->boolean('show')->default(false)->after('old_moderate');
      $table->dropColumn(['moderate']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('hotels', function (Blueprint $table) {
      $table->dropColumn(['old_moderate', 'show']);
      $table->boolean('moderate')->default('false');
    });
  }
}
