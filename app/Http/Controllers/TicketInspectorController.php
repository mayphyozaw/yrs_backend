<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketInspectorStoreRequest;
use App\Http\Requests\TicketInspectorUpdateRequest;
use App\Models\TicketInspector;
use App\Repositories\TicketInspectorRespository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class TicketInspectorController extends Controller
{
    
    protected $ticketInspectorRespository;

    public function __construct(TicketInspectorRespository $ticketInspectorRespository)
    {
        $this->ticketInspectorRespository = $ticketInspectorRespository;
    }
    
    
    
    public function index()
    {
        return view('ticket-inspector.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketInspectorRespository->datatable($request);
        }
    }

    public function create()
    {
        return view('ticket-inspector.create');
    }

    public function store(TicketInspectorStoreRequest $request)
    {
        try {
            $this->ticketInspectorRespository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            return Redirect::route('ticket-inspector.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ticket_inspector = $this->ticketInspectorRespository->find($id);
        return view('ticket-inspector.edit', compact('ticket_inspector'));
    }

    public function update($id, TicketInspectorUpdateRequest $request)
    {
        try {
            $this->ticketInspectorRespository->update($id,[
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request) : $this->ticketInspectorRespository->find($id)->password,
            ]);
            
            return Redirect::route('ticket-inspector.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->ticketInspectorRespository->delete($id);
            
            
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
