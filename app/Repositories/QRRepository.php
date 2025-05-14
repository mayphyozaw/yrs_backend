<?php

namespace App\Repositories;

use App\Models\OTP;
use App\Models\QR;
use App\Notifications\TwoStepVerification;
use App\Repositories\Contracts\BaseRepository;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class QRRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = QR::class;
    }

    public function find($id)
    {
        $record = $this->model::find($id);
        return $record;
    }

    public function create(array $data)
    {
        $record = $this->model::create($data);
        return $record;
    }

    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model::find($id);
        $record->delete();
    }

    public function generate($ticket_number)
    {

        $qr = $this->model::where('ticket_number', $ticket_number)->where('expired_at', '>', date('Y-m-d H:i:s'))->first();

        if (!$qr) {
            $qr = $this->create([
                'ticket_number' => $ticket_number,
                'token' => Str::uuid(),
                'expired_at' => now()->addMinutes(5)->format('Y-m-d H:i:s')

            ]);

            
        }
        
        return $qr;
    }

    public function regenerate($qr_token)
    {
        
        $qr = $this->model::where('token', $qr_token)->first();

        if (!$qr) {
            throw new Exception('The given data is invalid.');
        }

        $ticket_number = $qr->ticket_number;

        if ($qr->expired_at > date('Y-m-d H:i:s')) {
            throw new Exception('We have already an QR for (#' . $ticket_number . '). The QR will expire in ' . now()->diff($qr->expired_at)->format('%i minutes and %s seconds') . '.');
        }

        $this->delete($qr->id);

        $otp = $this->create([
            'ticket_number' => $ticket_number,
            'token' =>  Str::uuid(),
            'expired_at' => now()->addMinutes(5)->format('Y-m-d H:i:s')

        ]);
        
        return $qr;

    }


    
}
