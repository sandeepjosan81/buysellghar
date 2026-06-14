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
        Schema::create('lead_contacts', function (Blueprint $table) {
            $table->comment('Property Props');
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedBigInteger('product_id')->index('lead_product_id')->comment('Property ID');
            $table->string('name', 128)->comment('Name')->nullable();
            $table->string('contact_no')->comment('Seller Type')->nullable();
            $table->string('email', 128)->comment('email')->nullable();            
            $table->string('property_url')->comment('URL')->nullable();
            $table->string('interested_in')->comment('Interested In')->nullable();
            $table->boolean('status')->default(false)->comment('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_contacts');
    }
};
