<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class WalletTransactionRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = WalletTransaction::class;
    }

    public function find($id)
    {
        $record = $this->model::with(['user:id,name,email', 'sourceable'])->find($id);
        return $record;
    }

    public function create(array $data)
    {
        $record = $this->model::create($data);
        return $record;
    }

    public function update($id, array $data) {}

    public function delete($id) {}

    public function datatable(Request $request)
    {
        $model = WalletTransaction::with(['user:id,name,email']);

        return DataTables::eloquent($model)
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function($q1) use ($keyword){
                    $q1->where('name', 'LIKE', "%$keyword%")->orWhere('email','LIKE',"%$keyword%");
                });
            })
            ->addColumn('user_name', function ($wallet_transaction) {
                return ($wallet_transaction->user->name ?? '-') . '(' . ($wallet_transaction->user->email ?? '') . ')';
            })
            ->editColumn('method', function ($wallet_transaction) {
                // return $wallet_transaction->acsrMethod['text'];
                return '<span style="color: #' . $wallet_transaction->acsrMethod['color'] . '">' . $wallet_transaction->acsrMethod['text'] . '</span>';
            })
            ->editColumn('type', function ($wallet_transaction) {
                return '<span style="color: #' . $wallet_transaction->acsrType['color'] . '">' . $wallet_transaction->acsrType['text'] . '</span>';
            })
            ->editColumn('amount', function ($wallet_transaction) {
                return number_format($wallet_transaction->amount);
            })
            ->editColumn('created_at', function ($wallet_transaction) {
                return Carbon::parse($wallet_transaction->created_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('updated_at', function ($wallet_transaction) {
                return Carbon::parse($wallet_transaction->updated_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($wallet_transaction) {
                return view('wallet-transaction._action', compact('wallet_transaction'));
            })
            ->addColumn('responsive-icon', function ($wallet_transaction) {
                return null;
            })
            ->rawColumns(['method', 'type'])
            ->toJson();
    }
}
