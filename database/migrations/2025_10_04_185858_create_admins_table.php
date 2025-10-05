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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('account',20)->unique();
            $table->string('password',80);
            $table->string('name',20);
            $table->string('email',50)->unique();
            $table->string('phone',20)->unique()->nullable( true);
            $table->ipAddress('reg_ip',20)->nullable( true);
            $table->ipAddress('last_ip',20)->nullable( true);
            $table->timestamp('last_time')->nullable( true);
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
