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
        Schema::table('cost_types', static function (Blueprint $table) {
            $table->string('slug')->after('sort')->nullable();
        });

        \Domain\Room\Models\CostType::get()->each(function ($costType) {
            $costType->slug = Str::slug($costType->name);
            $costType->save();
        });

        Schema::table('cost_types', static function (Blueprint $table) {
            $table->string('slug')->after('sort')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('cost_types', static function (Blueprint $table) {
            $table->dropColumn(['slug']);
        });
    }
};
