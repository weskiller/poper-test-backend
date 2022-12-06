<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class School extends JsonResource
{
    /** @var \App\Models\School */
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
            'name' => $this->resource->name,
            'teachers' => $this->whenLoaded('teachers', fn() => Teacher::collection($this->resource->teachers)),
            'teacher_count' => $this->whenCounted('teachers', fn() => $this->resource->teachers_count),
            'students' => $this->whenLoaded('students', fn() => Teacher::collection($this->resource->students)),
            'student_count' => $this->whenCounted('students', fn() => $this->resource->students_count),
            'founder' => $this->whenLoaded('founder', fn() => new Teacher($this->resource->founder)),
            'updated_at' => $this->resource->updated_at,
            'created_at' => $this->resource->created_at,
        ];
    }
}
