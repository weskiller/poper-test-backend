<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class Teacher extends JsonResource
{
    /** @var \App\Models\Teacher */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'email' => $this->resource->email,
            'schools' => $this->whenLoaded('schools', static fn() => School::collection($this->resource->schools)),
            'updated_at' => $this->resource->updated_at,
            'created_at' => $this->resource->created_at,
        ];
    }
}
