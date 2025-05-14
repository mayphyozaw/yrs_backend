<?php

namespace App\Http\Controllers\Api\TicketInspectorPortal;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketInspectorPortal\TicketInspectionResource;
use App\Repositories\TicketInspectionRepository;
use App\Services\ResponseService;
use App\Services\TicketInspetionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TicketInspectionController extends Controller
{
    public function index()
    {
        $ticket_inspector = Auth::guard('ticket_inspectors_api')->user();

        $ticket_inspections = (new TicketInspectionRepository())
            ->queryByTicketInspector($ticket_inspector)
            ->with(['ticket:id,ticket_number,type', 'route:id,title'])
            ->paginate(10);

        return TicketInspectionResource::collection($ticket_inspections)->additional(['message' => 'success']);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'route_slug' => 'required|string',
                'qr_token' => 'required|string',
            ],
            [
                'route_slug.required' => 'The route field is required',
                'qr_token.required' => 'The QR field is required',
            ]
        );

        DB::beginTransaction();
        try {
            $ticket_inspection = TicketInspetionService::scanQr(
                Auth::guard('ticket_inspectors_api')->user(),
                $request->route_slug,
                $request->qr_token,
            );

            DB::commit();
            return ResponseService::success([
                'ticket_inspection_id' => $ticket_inspection->id,
            ], 'Successfully inspected');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
