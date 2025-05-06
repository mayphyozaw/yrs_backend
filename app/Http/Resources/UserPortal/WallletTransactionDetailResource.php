<?php

namespace App\Http\Resources\UserPortal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WallletTransactionDetailResource extends JsonResource
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
            'from' => $this->acsrFrom,
            'to' => $this->acsrTo,
            'type' => $this->acsrType,
            'method' => $this->acsrMethod,
            'amount' => number_format($this->amount) . ' MMK',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'description' => $this->description
        ];
    }
}
