<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Deal Stages (e.g., Prospecting, Qualified, Negotiation, Won, Lost)
        Schema::create('deal_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('position')->default(0);
            $table->integer('probability')->default(0); // Win probability %
            $table->timestamps();
        });

        // Leads
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained(); // Owner
            $table->string('title'); // Company or person name
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('new'); // New, Contacted, Qualified, Disqualified, Converted
            $table->text('notes')->nullable();
            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Deals
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained(); // Owner
            $table->foreignId('deal_stage_id')->constrained();
            $table->string('title');
            $table->decimal('value', 15, 2)->default(0);
            $table->date('expected_close_date')->nullable();
            $table->timestamp('won_at')->nullable();
            $table->timestamp('lost_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Activities (Tasks, Logs)
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->nullableMorphs('subject'); // Morph to Lead or Deal
            $table->string('type'); // call, email, meeting, task
            $table->text('description')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
        Schema::dropIfExists('deals');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('deal_stages');
    }
};
