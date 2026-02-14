<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notification_emails', function (Blueprint $table) {
            $table->dropForeign(['recipient_id']);
            $table->unsignedBigInteger('recipient_id')->nullable()->change();
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('notification_emails', function (Blueprint $table) {
            $table->dropForeign(['recipient_id']);
            $table->unsignedBigInteger('recipient_id')->nullable(false)->change();
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
