<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('surname');
            $table->timestamps();
        });

        (new \App\Models\Manager([
            "email"    => \App\Models\Manager::SYSTEM_MANAGER_EMAIL,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'name'     => 'Система',
            'surname'  => 'Системный',
        ]))->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers');
    }
}
