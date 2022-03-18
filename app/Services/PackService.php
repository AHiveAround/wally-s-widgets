<?php

namespace App\Services;

use App\Models\Pack;
use Illuminate\Http\Request;

class PackService
{
    /**
     * @var Pack
     */
    protected Pack $pack;

    /**
     * @param Pack $pack
     */
    public function __construct(
        Pack $pack
    ) {
        $this->pack = $pack;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validatePackInput(
        Request $request
    ): array {
        return $request->validate(['ordered-packs' => 'required|numeric|gt:0']);
    }

    /**
     * Get packs to send
     *
     * @param float $orderTotal
     * @return array|null
     */
    public function getPacksToSend(
        float $orderTotal
    ): ?array {
        $requiredPackSizes = [];
        $packSizes = $this->pack->all()->sortByDesc('size')->pluck('size');

        if ($packSizes->isEmpty()) {
            return null;
        }

        foreach ($packSizes as $key => $size) {
            if ($key === (count($packSizes) - 1)) {
                if ($size < $orderTotal) {
                    $requiredPackSizes[] = $packSizes->get(count($packSizes) - 2);
                    break;
                }
            }

            while ($size <= $orderTotal) {
                $orderTotal = $orderTotal - $size;
                $requiredPackSizes[] = $size;
            }

            if ($orderTotal > 0 && $size === $packSizes->last()) {
                $requiredPackSizes[] = $packSizes->last();
            }
        }

        return array_count_values($requiredPackSizes);
    }
}
