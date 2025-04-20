<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('investor');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->float('total_area');
            $table->integer('number_of_units');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
