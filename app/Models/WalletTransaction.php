<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WalletTransaction extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trx_id',
        'wallet_id',
        'user_id',
        'sourceable_id',
        'sourceable_type',
        'method',
        'type',
        'amount',
        'description',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

        // // polymophism "One To One"  from laravel documentation

    public function sourceable()
    {
        return $this->morphTo(); 
    }


    protected function acsrMethod(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['method']) {
                    case 'add':
                        $text = 'Add';
                        $sign = '+';
                        $color = '16a34a';
                        
                        break;

                    case 'reduce':
                        $text = 'Reduce';
                        $sign = '-';
                        $color = 'dc2626';
                        
                        break;
                        
                    default:
                        $text = '';
                        $sign = '';
                        $color = '4b45563';
                        
                        break;
                }
                return[
                    'text' => $text,
                    'sign' => $sign,
                    'color'=> $color,
                    
                ];
            },
            
        );
    }

    protected function acsrType(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['type']) {
                    case 'manual':
                        $text = 'Manual';
                        $color = '16a34a';
                        $icon = asset('image/transaction.png');
                        break;

                    case 'top_up':
                        $text = 'Top up';
                        $color = '2563eb';
                        $icon = asset('image/topup.png');
                        break;

                    case 'buy_ticket':
                        $text = 'Buy Ticket';
                        $color = '059669';
                        $icon = asset('image/buy-ticket.png');
                        break;
                        
                    default:
                        $text = '';
                        $color = '4b45563';
                        $icon = asset('image/transaction.png');
                        break;
                }
                return[
                    'text' => $text,
                    'color'=> $color,
                    'icon' => $icon,
                ];
            },
            
        );
    }

    protected function acsrFrom(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['method']) {
                    case 'add':
                        $from = $this->acsrType['text'];
                        break;

                    case 'reduce':
                        $from = $this->user->name;
                        break;

                    
                    default:
                         $from = '';
                        break;
                }
                return $from;
            }
            
        );
    }

    protected function acsrTo(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['method']) {
                    case 'add':
                        $to = $this->user->name;
                        break;

                    case 'reduce':
                        // $to = $this->acsrType['text'] .($this->sourceable ? '(#'.$this->sourceable->id. ')' : '');
                        $to = $this->acsrType['text'];
                        break;

                    
                    default:
                         $to = '';
                        break;
                }
                return $to;
            }
            
        );
    }

    
}
