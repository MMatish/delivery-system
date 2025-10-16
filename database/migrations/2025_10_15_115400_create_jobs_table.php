<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_address');
            $table->string('delivery_address');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->enum('status', ['unassigned', 'assigned', 'in_progress', 'completed', 'failed'])->default('unassigned');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
