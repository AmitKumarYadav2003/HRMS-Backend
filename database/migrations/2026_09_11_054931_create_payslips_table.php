<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('month');
            $table->integer('year');
            $table->decimal('basic', 10, 2);
            $table->decimal('hra', 10, 2);
            $table->decimal('allowance', 10, 2);
            $table->decimal('pf', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('net_pay', 10, 2);
            $table->date('credited_on')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};