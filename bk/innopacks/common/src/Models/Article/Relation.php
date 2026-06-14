<?php


namespace InnoShop\Common\Models\Article;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\Article;
use InnoShop\Common\Models\BaseModel;

class Relation extends BaseModel
{
    protected $table = 'article_relations';

    protected $fillable = [
        'article_id', 'relation_id',
    ];

    /**
     * Get the main article
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Get the related article
     * @return BelongsTo
     */
    public function relatedArticle(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'relation_id');
    }
}
