<?php


namespace InnoShop\Common\Models\Product;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Product;

class Relation extends BaseModel
{
    protected $table = 'product_relations';

    protected $fillable = [
        'product_id', 'relation_id',
    ];

    /**
     * Get the main product
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the related product
     * @return BelongsTo
     */
    public function relationProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'relation_id');
    }
}
