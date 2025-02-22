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
        Schema::table('weather_alerts', function (Blueprint $table) {
            $table->unique(['user_id', 'alert_type', 'notified', 'notified_at'], 'unique_user_alert');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weather_alerts', function (Blueprint $table) {
            $table->dropUnique('unique_user_alert');
        });
    }
};
