<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketPricingStoreRequest;
use App\Http\Requests\TicketPricingUpdateRequest;
use App\Repositories\TicketPricingRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class TicketPricingController extends Controller
{
    protected $ticketPricingRepository;

    public function __construct(TicketPricingRepository $ticketPricingRepository)
    {
        $this->ticketPricingRepository = $ticketPricingRepository;
    }



    public function index()
    {
        return view('ticket-pricing.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketPricingRepository->datatable($request);
        }
    }

    public function create()
    {
        return view('ticket-pricing.create');
    }



    public function store(TicketPricingStoreRequest $request)
    {
        
        try {
            $period = explode(' - ', $request->period);
            $this->ticketPricingRepository->create([
                'type' => $request->type,
                'price' => $request->price,
                'offer_quantity' => $request->offer_quantity,
                'remain_quantity' => $request->offer_quantity,
                'started_at'=> $period[0],
                'endeded_at'=> $period[1],
               
            ]);
            

            return Redirect::route('ticket-pricing.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $ticket_pricing = $this->ticketPricingRepository->find($id);
        return view('ticket-pricing.edit', compact('ticket_pricing'));
    }

    public function update($id, TicketPricingUpdateRequest $request)
    {
        try {
            $ticket_pricing = $this->ticketPricingRepository->find($id);
            $old_offer_quantity = $ticket_pricing->offer_quantity; //1000 in database
            $new_offer_quantity = $request->offer_quantity; // want to reduce 500 (-500)
            $change_offer_quantity = $new_offer_quantity - $old_offer_quantity; // (-500) =  500 - 1000
            $old_remain_quantity = $ticket_pricing->offer_quantity; // 900 in database (100 sold out)
            $new_remain_quantity = $old_remain_quantity + $change_offer_quantity ; // 900 + (-500) = 400
 

            $period = explode(' - ', $request->period);
            $this->ticketPricingRepository->update($id, [
                'type' => $request->type,
                'price' => $request->price,
                'offer_quantity' => $new_offer_quantity,
                'remain_quantity' => $new_remain_quantity,
                'started_at'=> $period[0],
                'endeded_at'=> $period[1],
               
            ]);

            return Redirect::route('ticket-pricing.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    

    public function destroy($id)
    {
        try {
            $this->ticketPricingRepository->delete($id);


            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
