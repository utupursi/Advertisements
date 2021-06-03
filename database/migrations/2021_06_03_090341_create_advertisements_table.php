<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->string('work_schedule');
            $table->string('experience');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('duties')->nullable();
            $table->text('requirements')->nullable();
            $table->string('salary_type')->nullable();
            $table->float('salary_amount')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->index(['category_id', 'city_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
