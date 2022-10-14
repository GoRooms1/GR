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
        Schema::create('filter_costs', static function (Blueprint $table) {
            $table->id();
            $table->integer('cost')->nullable();
            $table->foreignId('cost_type_id')
              ->constrained('cost_types')
              ->cascadeOnDelete()
              ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_costs');
    }
};
