<?php

use App\Models\User;
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
        Schema::create('c2c_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('pw')->nullable();
            $table->text('fireBaseDeviceId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c2c_users');
    }
};
