<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    // public static $wrap = 'ticket';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'ticket',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                    !$request->routeIs(['tickets.index', 'authors.tickets']),
                    $this->description,
                ),
                'status' => $this->status,
                'priority' => $this->priority,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ],
                    'attributes' => [
                        'name' => $this->author?->name,
                        'email' => $this->author?->email,
                    ],
                    'links' => [
                        'self' => route('authors.show', ['author' => $this->user_id])
                    ]
                ]
            ],
            'includes' => new UserResource($this->whenLoaded('author')),
            'links' => [
                'self' => route('tickets.show', ['ticket' => $this->id])
            ],
        ];
    }
}
