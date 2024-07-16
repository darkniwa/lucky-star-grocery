<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRemittancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop foreign key constraints
        Schema::table('remittances', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['receiver_id']);
        });

        // Drop the existing foreign key columns
        Schema::table('remittances', function (Blueprint $table) {
            $table->dropColumn(['sender_id', 'receiver_id', 'created_at', 'updated_at']);
        });

        // Add new columns
        Schema::table('remittances', function (Blueprint $table) {
            $table->bigInteger('order_number');
            $table->foreignId('payer_id')->nullable()->constrained('users');
            $table->foreignId('collector_id')->nullable()->constrained('users');
            $table->foreignId('remittance_handler_id')->nullable()->constrained('users');
            $table->enum('status', ['Pending', 'Collected', 'Remitted', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foreign key constraints
        Schema::table('remittances', function (Blueprint $table) {
            $table->dropForeign(['payer_id']);
            $table->dropForeign(['collector_id']);
            $table->dropForeign(['remittance_handler_id']);
        });

        Schema::table('remittances', function (Blueprint $table) {
            // Reverse the changes if needed
            $table->dropColumn(['payer_id', 'collector_id', 'remittance_handler_id', 'status', 'created_at', 'updated_at']);

            // Recreate foreign key constraints
            $table->foreignId('sender_id')->nullable()->constrained('users');
            $table->foreignId('receiver_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }
}
