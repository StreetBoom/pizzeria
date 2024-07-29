<?php

namespace App\Http\Controllers;

use App\Services\Order\OrderService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserProfileController extends Controller
{

    protected OrderService $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @return Factory|View|Application|\Illuminate\View\View
     */
    public function show()
    {
        return view('profile.show',
            [
                'user' => Auth::user(),
                'orders' => $this->orderService->ordersByUserId(Auth::id()),
            ]);
    }
}
