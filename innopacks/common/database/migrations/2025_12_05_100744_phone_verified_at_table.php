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
        Schema::table('admins', function (Blueprint $table) {            
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at'); 
             $table->string('sms_otp', 10)->nullable()->after('email_verified_at');
            $table->timestamp('sms_otp_expires_at')->nullable()->after('email_verified_at');
            $table->timestamp('sms_otp_sent_at')->nullable()->after('email_verified_at');
            $table->unsignedInteger('sms_otp_attempts')->default(0)->after('email_verified_at');
            $table->unsignedInteger('sms_otp_resend_count')->default(0)->after('email_verified_at');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('sms_otp', 10)->nullable()->after('email_verified_at');
            $table->timestamp('sms_otp_expires_at')->nullable()->after('email_verified_at');
            $table->timestamp('sms_otp_sent_at')->nullable()->after('email_verified_at');
            $table->unsignedInteger('sms_otp_attempts')->default(0)->after('email_verified_at');
            $table->unsignedInteger('sms_otp_resend_count')->default(0)->after('email_verified_at');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
        });
    }
};
