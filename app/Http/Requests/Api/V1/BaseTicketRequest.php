<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{

    public function mappedAttributes()
    {
        $attributesMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.attributes.priority' => 'priority',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.author.data.id' => 'user_id',
        ];
        $attributesToUpdate = [];
        foreach ($attributesMap as $key => $attribute) {
            if($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributesToUpdate;
    }

    public function messages(): array {
        return [
            'data.relationships.author.data.id.required' => 'The id field is required.',
        ];
    }
}
