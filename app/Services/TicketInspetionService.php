<?php

namespace App\Services;

use App\Http\Resources\UserPortal\TicketResource;
use App\Models\QR;
use App\Models\Route;
use App\Models\Ticket;
use App\Models\TicketInspections;
use App\Repositories\TicketInspectionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class TicketInspetionService
{
    public static function scanQr($ticket_inspector, $route_slug, $qr_token)
    {
        $route = Route::where('slug', $route_slug)->first();
        if(!$route){
            throw new Exception('The route is not found.');
        }

        $qr = QR::where('token', $qr_token)->first();
        if(!$qr){
            throw new Exception('The QR is invalid.');
        }

        if($qr->expired_at < date('Y-m-d H:i:s')){
            throw new Exception('The QR is expired.');
        }

        $ticket = Ticket::where('ticket_number', $qr->ticket_number)->first();
        if(!$ticket){
            throw new Exception('The ticket is not found.');
        }

        if(!($ticket->valid_at <= date('Y-m-d H:i:s') && $ticket->expire_at >= date('Y-m-d H:i:s'))){
            throw new Exception('The ticket is invalid.');
        }

        if($ticket->type == 'one_time_ticket'){
            if($route->direction != $ticket->direction){
                throw new Exception('The ticket direction does not match with the route direction.');
            }
            if(TicketInspections::where('ticket_id',$ticket->id)->exists()){
                throw new Exception('The ticket is already used.');
            }
        }
        
        $ticket_inspection = (new TicketInspectionRepository())->create([
            'ticket_id' => $ticket->id,
            'ticket_inspector_id' => $ticket_inspector->id,
            'route_id' => $route->id

        ]);
        
        return $ticket_inspection;
        
    }
}
