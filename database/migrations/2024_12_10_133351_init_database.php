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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->uuid('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')->references('id')->on('categories')->cascadeOnDelete();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->float('price')->notNull();
            $table->float('discount')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('sold')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('featured')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('address', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->string('postal_code', 255);
            $table->string('phone_number', 255);
            $table->timestamps();
        });
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('coupon_code')->unique();
            $table->enum('coupon_type', ['percent', 'fixed_amount']);
            $table->decimal('coupon_value', 10, 2);
            $table->date('coupon_start_date')->nullable();
            $table->date('coupon_end_date')->nullable();
            $table->decimal('coupon_min_spend', 10, 2)->nullable();
            $table->decimal('coupon_max_spend', 10, 2)->nullable();
            $table->integer('coupon_uses_per_customer')->nullable();
            $table->integer('coupon_uses_per_coupon')->nullable();
            $table->enum('coupon_status', ['active', 'expired', 'disabled'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('affiliates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_id')->index();
            $table->string('code')->unique();
            $table->float('commission');
            $table->decimal('balance', 18, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_id')->index();
            $table->string('status');
            $table->decimal('shipping_fee', 18, 2)->nullable();
            $table->decimal('total', 18, 2);
            $table->string('payment_id')->nullable();
            $table->string('coupon_id')->nullable();
            $table->string('affiliate_id')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('delivery_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('set null');
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_id');
            $table->string('product_id');
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_id')->index();
            $table->decimal('total_price', 18, 2)->default(0);
            $table->string('session_id');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
        Schema::create('cart_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('cart_id');
            $table->string('product_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_id')->index();
            $table->string('product_id')->index();
            $table->tinyInteger('rating')->unsigned()->comment('Rating from 1 to 5')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type', 50);
            $table->string('url');
            $table->string('path');
            $table->string('name')->nullable();
            $table->string('mime_type')->nullable();
            $table->bigInteger('size')->nullable();
            $table->timestamps();
        });
        Schema::create('product_assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('product_id');
            $table->string('asset_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
        Schema::create('attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255)->unique();
            $table->string('type', 50);
            $table->timestamps();
        });
        Schema::create('product_attribute_assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('product_id');
            $table->string('attribute_id');
            $table->string('asset_id');
            $table->string('value')->nullable()->comment('The specific value for this attribute');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_assets');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('product_assets');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('affiliates');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
