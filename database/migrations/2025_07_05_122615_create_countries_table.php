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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);

            $table->char('abv', 2)
                ->default('')
                ->comment('ISO 3661-1 alpha-2');

            $table->char('abv3', 3)
                ->nullable()
                ->comment('ISO 3661-1 alpha-3');

            $table->char('abv3_alt', 3)
                ->nullable();

            $table->char('code', 3)
                ->nullable()
                ->comment('ISO 3661-1 numeric');

            $table->string('slug', 100);

            $table->integer('phonecode')
                  ->comment('International Phone Code');

            $table->unique('slug');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
