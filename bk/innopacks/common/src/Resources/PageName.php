<?php


namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageName extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     * @throws Exception
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'     => $this->id,
            'slug'   => $this->slug,
            'name'   => $this->translation->title,
            'active' => (bool) $this->active,
        ];

        return fire_hook_filter('resource.page.name', $data);
    }
}
