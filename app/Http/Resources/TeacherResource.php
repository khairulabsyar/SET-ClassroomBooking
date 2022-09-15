<?php

namespace App\Http\Resources;

use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $var = Str::random(10);
        return [
            'full_name' => $this->name,
            'created_at' => $this->created_at->format('Y-m-d'),
            // conditional to attach data
            'created_at_exist' => $this->when(true, function () {
                return "It exist in teacher";
            }),
            'false' => $this->when(false, function () {
                return "It exist in teacher";
            }),
            'random_var' => $var,
            // 'pass_data' => $this->pass_data ?? "No Pass",
            // or
            'pass_data' => $this->when(isset($this->pass_data), function () {
                return $this->pass_data;
            }, 'No Pass')
        ];
    }
}