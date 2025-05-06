<?php

namespace App\Http\Resources\UserPortal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopupHistoryDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trx_id' => $this->trx_id,
            'user_text' => $this->user->name ?  $this->user->name . '(' . $this->user->email . ')' : '-',
            'amount' => number_format($this->amount) . ' MMK',
            'description' => $this->description,
            'status' => $this->acsrStatus,
            'approved_at' => $this->approved_at ? Carbon::parse($this->approved_at)->format('Y-m-d H:i:s') : '-',
            'rejected_at' => $this->rejected_at ? Carbon::parse($this->rejected_at)->format('Y-m-d H:i:s') : '-',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'image' => $this->acsrImagePath,
        ];
    }
}
