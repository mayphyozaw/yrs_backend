<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class TopUpHistory extends Model
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
        'amount',
        'description',
        'image',
        'status',
        'approved_at',
        'rejected_at',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


    protected function acsrStatus(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['status']) {
                    case 'pending':
                        $text = 'Pending';
                        $color = 'ea580c';
                        break;

                    case 'approve':
                        $text = 'Approve';
                        $color = '16a34a';
                        break;

                    case 'reject':
                        $text = 'Reject';
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

    protected function acsrImagePath(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                return Storage::url('top-up-history/'. $attributes['image']);
                
            },
        );
    }

}
