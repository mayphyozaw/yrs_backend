<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\WalletRepository;

class WalletController extends Controller
{
    protected $walletRespository;

    public function __construct(WalletRepository $walletRespository)
    {
        $this->walletRespository = $walletRespository;
    }
    
    
    
    public function index()
    {
        return view('wallet.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->walletRespository->datatable($request);
        }
    }
}
