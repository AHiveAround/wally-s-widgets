<?php

namespace App\Http\Controllers;

use App\Services\PackService;
use Illuminate\Http\Request;

class PackController extends Controller
{
    /**
     * @var PackService
     */
    public $packService;

    public function index() {
        return view('index', $this->getPacksToSend(251));
    }

    /**
     * @param PackService $packService
     */
    public function __construct(
        PackService $packService
    ) {
        $this->packService = $packService;
    }

    public function getPacksToSend(
        int $orderTotal
    ): array {
        return $this->packService->getPacksToSend($orderTotal);
    }
}
