<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('package_type');
            $table->decimal('price', 8, 2);
            $table->string('duration');
            $table->text('description');
            $table->unsignedBigInteger('hotel_details');
            $table->string('laugage_capacity');
            $table->integer('group_size')->nullable();
            $table->date('departure_date');
            $table->date('return_date');
            $table->string('contact_information')->nullable();
            $table->timestamps();

            $table->foreign('hotel_details')->references('id')->on('hotels');
            // $table->boolean('meals_included')->default(false);
            // $table->string('guides')->nullable();
            // $table->boolean('visa_assistance')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
