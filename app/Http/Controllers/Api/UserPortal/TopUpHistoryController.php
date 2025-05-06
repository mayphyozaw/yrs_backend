<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserPortal\TopupHistoryDetailResource;
use App\Http\Resources\UserPortal\TopupHistoryResource;
use App\Repositories\TopUpHistoryRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpHistoryController extends Controller
{
    
    protected $topUpHistoryRepository;

    public function __construct(TopUpHistoryRepository $topUpHistoryRepository)
    {
        $this->topUpHistoryRepository = $topUpHistoryRepository;
    }
    
    public function index(Request $request)
    {
        $user = Auth::guard('users_api')->user();
        $top_up_histories = $this->topUpHistoryRepository->queryByUser($user)
            ->when($request->search, function ($q1) use ($request) {
                $q1->where('trx_id', 'LIKE', "%$request->search%")
                    ->orWhere('amount', 'LIKE', "%$request->search%")
                    ->orWhere('created_at', 'LIKE', "%$request->search%");
            })
            ->orderByDesc('id')
            ->paginate(10);
        return TopupHistoryResource::collection($top_up_histories)->additional(['message' => 'success']);
    }

    public function show($trx_id)
    {
        $user = Auth::guard('users_api')->user();
        $top_up_history = $this->topUpHistoryRepository->queryByUser($user)
            ->with(['user:id,name,email'])    
            ->where('trx_id',$trx_id)
            ->firstOrFail();

        return ResponseService::success(new TopupHistoryDetailResource($top_up_history));
    }
}
