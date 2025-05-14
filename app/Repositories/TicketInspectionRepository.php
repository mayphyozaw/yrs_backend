<?php

namespace App\Repositories;

use App\Models\OTP;
use App\Models\QR;
use App\Models\TicketInspections;
use App\Repositories\Contracts\BaseRepository;
use Exception;
use Illuminate\Support\Str;

class TicketInspectionRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = TicketInspections::class;
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

    public function queryByTicketInspector($ticket_inspector)
    {
        return $this->model::where('ticket_inspector_id', $ticket_inspector->id);
    }

}
