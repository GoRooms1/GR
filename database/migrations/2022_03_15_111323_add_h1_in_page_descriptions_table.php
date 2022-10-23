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
        Schema::table('page_descriptions', static function (Blueprint $table) {
            $table->text('h1')->after('title')->nullable();
        });

        Schema::table('page_descriptions', static function (Blueprint $table) {
            \Domain\PageDescription\Models\PageDescription::all()->each(function (
                Domain\PageDescription\Models\PageDescription $item) {
                $item->h1 = $item->title;
                $item->save();
            });
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
            $table->dropColumn(['h1']);
        });
    }
};
