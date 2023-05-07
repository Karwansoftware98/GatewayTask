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
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->integer('age');
            $table->decimal('salary', 19, 4);
            $table->date('hired_date');
            $table->foreignId('gender_id')->constrained('genders');
            $table->foreignId('manager_id')->nullable()->constrained('employees');
            $table->string('job_title')->index();
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
        Schema::dropIfExists('employees');
    }
};
