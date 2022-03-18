<?php

namespace App\Http\Controllers;

use App\Services\PackService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PackController extends Controller
{
    /**
     * @var PackService
     */
    public $packService;

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
     * @return Application|Factory|View
     */
    public function getPacksToSend(
        Request $request
    ): Application|Factory|View {
        $ordered = $request->validate([
            'ordered-packs' => 'required|numeric|gt:0'
        ]);
        $orderedPackets = $this->packService->getPacksToSend($ordered['ordered-packs']);

        return view('shippedPacks', ['orderedPackets' => $orderedPackets]);
    }
}
