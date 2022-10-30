<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

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
        Schema::table('attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_category_id')->after('name');
        });

        \Domain\Attribute\Model\Attribute::query()->update(['attribute_category_id' => 1]);

        Schema::table('attributes', function (Blueprint $table) {
            $table->foreign('attribute_category_id')
              ->references('id')
              ->on('attribute_categories')
              ->onUpdate('cascade')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn(['attribute_category_id']);
        });
    }
};
