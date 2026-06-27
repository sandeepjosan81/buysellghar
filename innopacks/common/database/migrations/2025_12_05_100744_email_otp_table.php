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
            if (! Schema::hasColumn('admins', 'email_otp')) {
                $table->timestamp('email_verified_at')->nullable()->after('password')->comment('Timestamp for email verification');
                $table->string('email_otp', 10)->nullable()->after('password')->comment('One-time password for email verification');
                $table->string('whatsapp_no', 15)->nullable()->after('password')->comment('WhatsApp number for contact');
                $table->unique('whatsapp_no');
                $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'email_otp')) {
                $table->dropColumn('email_otp');
            }
            if (Schema::hasColumn('admins', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
            if (Schema::hasColumn('admins', 'whatsapp_no')) {
                $table->dropColumn('whatsapp_no');
            }
            if (Schema::hasColumn('admins', 'phone_verified_at')) {
                $table->dropColumn('phone_verified_at');
            }
        });
    }
};
