<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('godparent_id')->constrained('godparents')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->string('payment_proof')->nullable(); // Capture d'écran du virement
            $table->text('message')->nullable(); // Message personnel du parrain
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();

            // Index pour les requêtes fréquentes
            $table->index(['student_id', 'payment_status']);
            $table->index(['godparent_id', 'payment_status']);
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsorships');
    }
};
