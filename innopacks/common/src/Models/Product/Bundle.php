<?php


namespace InnoShop\Common\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\Product;

class Bundle extends Model
{
    protected $table = 'product_bundles';

    protected $fillable = [
        'product_id', 'sku_id', 'quantity',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class, 'sku_id');
    }
}
