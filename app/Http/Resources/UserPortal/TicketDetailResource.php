<?php

namespace App\Http\Resources\UserPortal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_number' => $this->ticket_number,
            'type'=> $this->acsrType,
            'direction'=> $this->acsrDirection,
            'price'=> number_format($this->price) . ' MMK',
            'valid_at' => Carbon::parse($this->valid_at)->format('Y-m-d H:i:s'),
            'expire_at' => Carbon::parse($this->expire_at)->format('Y-m-d H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
