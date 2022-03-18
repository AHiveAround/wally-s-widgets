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
     * @param float $remainingPacks
     * @return array|null
     */
    public function getPacksToSend(
        float $remainingPacks
    ): ?array {
        $requiredPackSizes = [];
        $packSizes = $this->pack->all()->sortByDesc('size')->pluck('size');

        if ($packSizes->isEmpty()) {
            return null;
        }

        foreach ($packSizes as $key => $size) {
            $qty = floor($remainingPacks / $size);
            $remainingPacks = $remainingPacks % $size;

            if ($key === (count($packSizes) - 2)) {
                if ($size > $remainingPacks && $remainingPacks > $packSizes->get(count($packSizes) - 1)) {
                    $remainingPacks = 0;
                    $qty++;
                }
            }

            if ($remainingPacks > 0 && $size === $packSizes->last()) {
                $qty++;
            }

            if ($qty) {
                $requiredPackSizes[] = ['size' => $size, 'qty' => $qty];
            }
        }

        return $requiredPackSizes;
    }
}
