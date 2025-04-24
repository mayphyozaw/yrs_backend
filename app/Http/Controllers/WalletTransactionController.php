<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use App\Repositories\WalletTransactionRepository;
use Illuminate\Http\Request;

class WalletTransactionController extends Controller
{
    protected $walletTransactionRepository;

    public function __construct(WalletTransactionRepository $walletTransactionRepository)
    {
        $this->walletTransactionRepository = $walletTransactionRepository;
    }
    
    public function index()
    {
        
        return view('wallet-transaction.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->walletTransactionRepository->datatable($request);
        }
    }

    public function show($id)
    {
        $wallet_transaction = $this->walletTransactionRepository->find($id);
        return view('wallet-transaction.show',compact('wallet_transaction'));
    }
}
