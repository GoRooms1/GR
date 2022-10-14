<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use App\Models\Hotel;
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
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['type_fond']);
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->boolean('checked_type_fond')->default(false)->after('old_moderate');
            $table->string('type_fond')->default(Hotel::ROOMS_TYPE)->nullable()->after('old_moderate');
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
            $table->dropColumn(['type_fond', 'checked_type_fond']);
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->string('type_fond')->default(Hotel::ROOMS_TYPE)->after('old_moderate');
        });
    }
};
