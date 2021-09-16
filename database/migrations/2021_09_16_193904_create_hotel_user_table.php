<?php

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelUserTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('hotel_user', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('hotel_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
      $table->string('hotel_position')->default(User::POSITION_GENERAL);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('hotel_user');
  }
}
