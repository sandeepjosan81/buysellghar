<?php


namespace InnoShop\Common\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleListItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'    => $this->id,
            'title' => $this->translation->title ?? '',
        ];

        return fire_hook_filter('resource.article.list_item', $data);
    }
}
