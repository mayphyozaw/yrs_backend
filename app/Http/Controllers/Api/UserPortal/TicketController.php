<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserPortal\TicketDetailResource;
use App\Http\Resources\UserPortal\TicketResource;
use App\Repositories\QRRepository;
use App\Repositories\TicketRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TicketController extends Controller
{
    
    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }
    
    public function index(Request $request)
    {
        $user = Auth::guard('users_api')->user();
        $tickets = $this->ticketRepository->queryByUser($user)
            ->when($request->search, function ($q1) use ($request) {
                $q1->where('trx_id', 'LIKE', "%$request->search%")
                    ->orWhere('amount', 'LIKE', "%$request->search%")
                    ->orWhere('created_at', 'LIKE', "%$request->search%");
            })
            ->orderByDesc('id')
            ->paginate(10);
        return TicketResource::collection($tickets)->additional(['message' => 'success']);
    }

    public function show($ticket_number)
    {
        $user = Auth::guard('users_api')->user();
        $ticket = $this->ticketRepository->queryByUser($user)
            ->where('ticket_number',$ticket_number)
            ->firstOrFail();

        return ResponseService::success(new TicketDetailResource($ticket));
    }

    public function regenerateQR(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $qr = (new QRRepository())->regenerate($request->qr_token);
            

            DB::commit();
            return ResponseService::success([
                'qr_token' => $qr->token
            ], 'Successfully regenerate.');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
