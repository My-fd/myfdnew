<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Тип атрибута (например, 'radio', 'checkbox')
            $table->text('options')->nullable(); // Возможные значения, сериализованные в JSON
            $table->text('comment')->nullable(); // Комментарий
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attributes');
    }
};
