<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class TicketPricing extends Model
{

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'price',
        'offer_quantity',
        'remain_quantity',
        'started_at',
        'ended_at',
    ];
    protected function acsrType(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['type']) {
                    case 'one_time_ticket':
                        $text = 'One Time Ticket';
                        $color = '16a34a';
                        break;

                    case 'one_month_ticket':
                        $text = 'One Month Ticket';
                        $color = '2563eb';
                        break;
                        
                    default:
                        $text = '';
                        $color = '4b45563';
                        break;
                }
                return[
                    'text' => $text,
                    'color'=> $color
                ];
            },
            
        );
    }

}
