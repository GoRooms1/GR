<?php

use App\Models\Metro;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValueMetroTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('metros', static function (Blueprint $table) {
      $table->string('api_value')->nullable(true)->after('name');
    });

    $metros = Metro::each(static function ($metro) {
      $metro->api_value = $metro->name;
      $metro->save();
    });

    Schema::table('metros', static function (Blueprint $table) {
      $table->string('api_value')->nullable(false)->after('name')->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('metros', static function (Blueprint $table) {
      $table->dropColumn(['api_value']);
    });
  }
}
