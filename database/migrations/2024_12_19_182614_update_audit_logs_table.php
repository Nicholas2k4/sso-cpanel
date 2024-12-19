<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->change();
            $table->text('description')->default('')->change();
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
        });
    }
};
