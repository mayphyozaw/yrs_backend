<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'ticket_pricing_id',
        'type',
        'direction',
        'price',
        'valid_at',
        'expire_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ticket_pricing()
    {
        return $this->belongsTo(TicketPricing::class, 'ticket_pricing_id', 'id');
    }


    protected function acsrType(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['type']) {
                    case 'one_time_ticket':
                        $text = 'One Time Ticket';
                        $color = '16a34a';
                        $icon = asset('image/one-time-ticket.png');
                        break;

                    case 'one_month_ticket':
                        $text = 'One Month Ticket';
                        $color = '2563eb';
                        $icon = asset('image/one-month-ticket.png');
                        break;

                    default:
                        $text = '';
                        $color = '4b45563';
                        $icon = asset('image/ticket.png');
                        break;
                }
                return [
                    'text' => $text,
                    'color' => $color,
                    'icon' => $icon,
                ];
            },

        );
    }



    protected function acsrDirection(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['direction']) {
                    case 'clockwise':
                        $text = 'Clockwise';
                        $color = '16a34a';
                        break;

                    case 'anticlockwise':
                        $text = 'Anticlockwise';
                        $color = '2563eb';
                        break;

                    case 'both':
                        $text = 'Both';
                        $color = 'ea580c';
                        break;

                    default:
                        $text = '';
                        $color = '4b45563';
                        break;
                }
                return [
                    'text' => $text,
                    'color' => $color
                ];
            },

        );
    }
}
