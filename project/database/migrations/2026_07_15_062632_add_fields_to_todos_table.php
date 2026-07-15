<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->enum('status', ['Not Started', 'In Progress', 'Completed', 'Cancelled'])
                ->default('Not Started')
                ->after('description');

            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])
                ->default('Low')
                ->after('status');

            $table->dateTime('due_date')->nullable()->after('priority');

            $table->string('category')->nullable()->after('due_date');
        });
    }

    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn(['status', 'priority', 'due_date', 'category']);
        });
    }
};