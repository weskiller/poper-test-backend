<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SchoolTeacher extends JsonResource
{
    /** @var \App\Models\SchoolTeacher */
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
            'teacher' => $this->whenLoaded('teacher', fn() => $this->resource->teacher),
            'school' => $this->whenLoaded('school', fn() => $this->resource->school),
            'level' => $this->resource->level,
            'updated_at' => $this->resource->updated_at,
            'created_at' => $this->resource->created_at,
        ];
    }
}
