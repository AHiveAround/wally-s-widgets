<?php

namespace App\Services;

use App\Models\Pack;

class PackService
{
    /**
     * @param Pack $pack
     */
    public function __construct(
        Pack $pack
    ) {
        $this->pack = $pack;
    }

    /**
     * Get packs to send
     *
     * @param float $orderTotal
     * @return array
     */
    public function getPacksToSend(
        float $orderTotal
    ): array {
        $requiredPackSizes = [];
        $packSizes = $this->pack->all()->sortByDesc('size')->pluck('size');

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
