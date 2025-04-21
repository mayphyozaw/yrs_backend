<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletAddAmountStoreRequest;
use App\Http\Requests\WalletReduceAmountStoreRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Repositories\WalletRepository;
use App\Services\WalletService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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

    public function addAmount()
    {
        $selected_wallet = old('wallet_id') ? Wallet::find(old('wallet_id')) : null;
        return view('wallet.add-amount',compact('selected_wallet'));
    }

    public function addAmountStore(WalletAddAmountStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            throw new Exception ('hello');
            WalletService::addAmount([
                'wallet_id' => $request->wallet_id,
                'sourceable_id'=>null,
                'sourceable_type' => null,
                'type' => 'manual',
                'amount' => $request->amount,
                'description'=>$request->description,

            ]);
        DB::commit();
            return Redirect::route('wallet.index')->with('success', 'Successfully added');
        } catch (Exception $e) {
        DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput(); 
        }
    }

    //reduceAmount
    public function reduceAmount()
    {
        $selected_wallet = old('wallet_id') ? Wallet::find(old('wallet_id')) : null;
        return view('wallet.reduce-amount',compact('selected_wallet'));
    }

    public function reduceAmountStore(WalletReduceAmountStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            WalletService::reduceAmount([
                'wallet_id' => $request->wallet_id,
                'sourceable_id'=>null,
                'sourceable_type' => null,
                'type' => 'manual',
                'amount' => $request->amount,
                'description'=>$request->description,

            ]);
        DB::commit();
            return Redirect::route('wallet.index')->with('success', 'Successfully added');
        } catch (Exception $e) {
        DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput(); 
        }
    }
}
