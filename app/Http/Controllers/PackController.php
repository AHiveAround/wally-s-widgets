<?php

namespace App\Http\Controllers;

use App\Services\PackService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PackController extends Controller
{
    /**
     * @var PackService
     */
    protected PackService  $packService;

    /**
     * @param PackService $packService
     */
    public function __construct(
        PackService $packService
    ) {
        $this->packService = $packService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function getPacksToSend(
        Request $request
    ): Application|Factory|View|RedirectResponse {
        $ordered = $this->packService->validatePackInput($request);
        $orderedPackets = $this->packService->getPacksToSend($ordered['ordered-packs']);

        if (!$orderedPackets) {
            return back()->withErrors('No packet sizes available');
        }

        return view('shippedPacks', ['orderedPackets' => $orderedPackets]);
    }
}
