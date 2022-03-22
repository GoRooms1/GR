<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeInPageDescriptionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('page_descriptions', static function (Blueprint $table) {
      $table->string('type')->after('description')->default('city');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('page_descriptions', static function (Blueprint $table) {
      $table->dropColumn(['type']);
    });
  }
}
