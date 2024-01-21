<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('listing_attribute', function (Blueprint $table) {
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->string('value'); // Значение атрибута для конкретного объявления
            $table->primary(['listing_id', 'attribute_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('listing_attribute');
    }
};
