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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender');
            $table->string('phone', 12);
        });

        Schema::create('user_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('postcode');
            $table->string('name');
            $table->string('phone', 12);
            $table->string('prefecture');
            $table->string('city');
            $table->string('address');
            $table->string('etc_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'bio', 'avatar', 'gender', 'phone', 'email']);
        });
        Schema::dropIfExists('user_addresses');
    }
};
