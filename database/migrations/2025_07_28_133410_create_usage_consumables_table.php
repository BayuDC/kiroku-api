<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsageConsumablesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('usage_consumables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usage_id')->constrained('usages')->onDelete('cascade');
            $table->foreignId('consumable_id')->constrained('consumables')->onDelete('cascade');
            $table->bigInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('usage_consumables');
    }
}
