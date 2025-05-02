<?php

namespace App\Repositories;

use App\Models\Station;
use App\Models\Ticket;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class TicketRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Ticket::class;
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


    public function datatable(Request $request)
    {
        $model = $this->model::with(['user:id, name, email']);

        return DataTables::eloquent($model)
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%");
                });
            })
            ->addColumn('user_name', function ($ticket) {
                return $ticket->user ? ($ticket->user->name . '(' . $ticket->user->email . ')') : '';
            })
            ->editColumn('type', function ($ticket) {
                return '<span style="color: #' . $ticket->acsrType['color'] . '">' . $ticket->acsrType['text'] . '</span>';
            })
            ->editColumn('direction', function ($ticket) {
                return '<span style="color: #' . $ticket->acsrDirection['color'] . '">' . $ticket->acsrDirection['text'] . '</span>';
            })
            ->editColumn('price', function ($ticket) {
                return number_format($ticket->price);
            })
            ->editColumn('created_at', function ($ticket) {
                return Carbon::parse($ticket->created_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('updated_at', function ($ticket) {
                return Carbon::parse($ticket->updated_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($ticket) {
                return view('ticket._action', compact('ticket'));
            })

            ->addColumn('responsive-icon', function ($ticket) {
                return null;
            })
            ->rawColumns(['type', 'direction', 'action'])
            ->toJson();
    }
}
