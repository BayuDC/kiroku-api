<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysForSoftDeletes extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // Drop existing foreign key constraints and recreate them with restrict behavior
        // This prevents hard deletes when there are soft-deleted related records

        Schema::table('tools', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
        });

        Schema::table('consumables', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        // Restore original cascade behavior
        Schema::table('tools', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::table('consumables', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
