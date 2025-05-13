<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Repositories\TicketPricingRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class TicketPricingController extends Controller
{
    protected $ticketPricingRepository;

    public function __construct(TicketPricingRepository $ticketPricingRepository)
    {
        $this->ticketPricingRepository = $ticketPricingRepository;
    }
    
    public function index()
    {
        $pricings = [];
        $ticket_pricings = $this->ticketPricingRepository->queryBYDateTime(date('Y-m-d H:i:s'))->get();
        
        foreach(['one_time_ticket', 'one_month_ticket'] as $type){
            $filtered_ticket_pricings = $ticket_pricings->where('type', $type);
            if(count($filtered_ticket_pricings)){
                if($type == 'one_time_ticket'){
                    $pricings[] = [
                        'type' => 'one_time_ticket',
                        'title' => 'One Time Ticket',
                        'price' => implode(', ', collect($filtered_ticket_pricings)->map(function($filtered_ticket_pricings){
                            return $filtered_ticket_pricings->acsrDirection['text'] . ':' . number_format($filtered_ticket_pricings->price) . ' MMK';
                        })->toArray()),
                        'description' => 'One Time Ticket is valid for one journey. The ticket is only valid for the day it was purchased and cannot be reused after the journey.'
                    ];

                }else if($type == 'one_month_ticket'){
                    $pricings[] = [
                        'type' => 'one_month_ticket',
                        'title' => 'One Month Ticket',
                        'price' => implode(', ', collect($filtered_ticket_pricings)->map(function($filtered_ticket_pricings){
                            return number_format($filtered_ticket_pricings->price) . ' MMK';
                        })->toArray()),
                        'description' => 'One Month Ticket is valid for unlimited journey. The ticket is valid for the month it was purchased.'
                    ];
                }
            }
        }
       return ResponseService::success($pricings);
    }
}
