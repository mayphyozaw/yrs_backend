<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketRespository;

    public function __construct(TicketRepository $ticketRespository)
    {
        $this->ticketRespository = $ticketRespository;
    }



    public function index()
    {
        return view('ticket.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketRespository->datatable($request);
        }
    }

    public function show($id)
    {
        $ticket = $this->ticketRespository->find($id);
        return view('ticket.show', compact('ticket'));
    }

    
}
