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
        Schema::table('payslips', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('credited_on'); // draft, approved
            $table->foreignId('approved_by')->nullable()->after('status')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->unique(['user_id', 'month', 'year']); // ek mahine ki ek hi payslip
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'month', 'year']);
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['status', 'approved_at']);
        });
    }
};
