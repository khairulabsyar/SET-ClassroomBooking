<?php

namespace App\Http\Resources;

use App\Models\Classroom;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ClassroomsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'topic' => $this->name,
            'teacher_name' => $this->teacher->name,
            'category' => $this->classroomType->name,
            'date' => $this->date,
            'time' => $this->time_start . ' to ' . $this->time_end,
            'attachment' => optional($this->attachment)->uri
        ];
    }
}
