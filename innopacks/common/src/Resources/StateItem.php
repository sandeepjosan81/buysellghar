<?php


namespace InnoShop\Common\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateItem extends JsonResource
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
            'id'   => $this->id,
            'name' => $this->name,
            'code' => $this->code,
        ];

        return fire_hook_filter('resource.state.item', $data);
    }
}
