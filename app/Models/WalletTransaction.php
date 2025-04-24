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
                        $color = '16a34a';
                        break;

                    case 'reduce':
                        $text = 'Reduce';
                        $color = 'dc2626';
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

    protected function acsrType(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['type']) {
                    case 'manual':
                        $text = 'Manual';
                        $color = 'ea580c';
                        break;

                    case 'top_up':
                        $text = 'Top up';
                        $color = '2563eb';
                        break;

                    case 'buy_ticket':
                        $text = 'Buy Ticket';
                        $color = '059669';
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

    protected function acsrFrom(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['method']) {
                    case 'add':
                        $from = $this->acsrType['text'] .($this->sourceable ? '(#'.$this->sourceable->id. ')' : '');
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
                        $to = $this->acsrType['text'] .($this->sourceable ? '(#'.$this->sourceable->id. ')' : '');
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
