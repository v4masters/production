<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model
{
    // Define the table and primary key
    protected $table = 'orders';
    protected $primaryKey = 'invoice_number';
    public $incrementing = false; // Assuming 'invoice_number' is not auto-increment
    protected $keyType = 'string'; // Change to 'int' if your invoice_number is numeric

    protected $fillable = [
        'invoice_number',
        'user_id',
        'order_status',
        'mode_of_payment',
        'batch_id',
        'payment_status',
        'status',
        'print_status',
        // Add other fields from orders table if needed
    ];

    /**
     * Get the order payment record.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Paytm::class, 'order_id', 'invoice_number');
    }

    /**
     * Get the user who placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'unique_id');
    }

    /**
     * Get the tax register info for this order.
     */
    public function taxRegister(): HasOne
    {
        return $this->hasOne(SaleTaxRegisterModel::class, 'order_id', 'invoice_number');
    }

    /**
     * Get the shipping address for this order.
     */
    public function shippingAddress(): HasOne
    {
        return $this->hasOne(OrderShippingAddressModel::class, 'invoice_number', 'invoice_number');
    }

    /**
     * Get the vendor through the tax register.
     */
    public function vendor(): HasOneThrough
    {
        return $this->hasOneThrough(
            VendorModel::class,
            SaleTaxRegisteModelr::class,
            'order_id',        // Foreign key on sale_tax_register table
            'unique_id',       // Foreign key on vendor table
            'invoice_number',  // Local key on orders table
            'vendor_id'        // Local key on sale_tax_register table
        );
    }
}
