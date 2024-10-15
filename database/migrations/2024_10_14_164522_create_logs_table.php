<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->string('action'); // create, update, delete
            $table->string('badge'); // success(save), update (primary), delete *(danger)
            $table->unsignedBigInteger(column: 'affected_record_id');
            $table->json('original_data')->nullable();
            $table->json('updated_data')->nullable();
            $table->foreignIdFor(
                \App\Models\User::class,
                'by_user_id'
                )->constrained('users');
                $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
