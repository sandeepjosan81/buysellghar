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
        Schema::create('property_props', function (Blueprint $table) {
            $table->comment('Property Props');
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedBigInteger('product_id')->index('ps_product_id')->comment('Product ID');
            $table->string('seller_type')->comment('Seller Type')->nullable();;
            $table->string('property_for', 128)->comment('Property For')->nullable();;
            $table->string('model')->comment('Model')->nullable();
            $table->string('list_type', 128)->comment('List Type')->nullable();
            $table->string('location')->comment('Location')->nullable();
            $table->string('city')->comment('City')->nullable();
            $table->string('address')->comment('Address')->nullable();
            $table->string('bedrooms')->comment('Bedrooms')->nullable();
            $table->string('balconies')->comment('Balconies')->nullable();
            $table->string('total_floors')->comment('Total Floors')->nullable();
            $table->string('floor_no')->comment('Floor Number')->nullable();
            $table->string('facing')->comment('Facing')->nullable();
            $table->string('balcony')->comment('Balcony')->nullable();
            $table->string('furnished_status')->comment('Furnished Status')->nullable();
            $table->string('bathrooms')->comment('Bathrooms')->nullable();
            $table->string('allowed_floors')->comment('Allowed Floors')->nullable();
            $table->string('open_side')->comment('Open Side')->nullable();
            $table->string('plot_area')->comment('Plot Area')->nullable(); 
            $table->string('plot_area_type')->comment('Plot Area Type')->nullable();
            $table->string('plot_length')->comment('Plot Length')->nullable();
            $table->string('plot_breadth')->comment('Plot Breadth')->nullable();
            $table->string('covered_area')->comment('Covered Area')->nullable();
            $table->string('covered_area_type')->comment('Covered Area Type')->nullable();
            $table->string('carpet_area')->comment('Carpet Area')->nullable();
            $table->string('carpet_area_type')->comment('Carpet Area Type')->nullable();
            $table->string('super_builtup_area')->comment('Super Built-up Area')->nullable();
            $table->string('super_builtup_area_type')->comment('Carpet Area Type')->nullable();
            $table->string('price')->comment('Price')->nullable();
            $table->string('price_type')->comment('Price Type')->nullable();
            $table->string('property_age')->comment('Property Age')->nullable();
            $table->string('maintenance_cost')->comment('Maintenance Cost')->nullable();
            $table->string('maintenance_cost_period')->comment('Maintenance Cost Period')->nullable();
            $table->string('ownership_status')->comment('Ownership Status')->nullable();
            $table->string('possession_status')->comment('Possession Status')->nullable();
            $table->string('rera_registration_no')->comment('Rera Registration No')->nullable();
            $table->string('transaction_type')->comment('Transaction Type')->nullable();
            $table->boolean('is_corner')->default(false)->comment('Is Corner');
            // $table->boolean('is_default')->comment('Default Or Not');
            $table->integer('position')->default(0)->comment('Sort order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_porps');
    }
};
