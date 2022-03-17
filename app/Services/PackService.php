<?php


namespace App\Services;


use App\Models\Pack;

class PackService
{
    /**
     * Get packs to send
     *
     * @param int $ordered
     * @return array
     */
    public function getPacksToSend(
        int $orderTotal
    ): array {
        $requiredPackSizes = [];
        $packSizes = Pack::all()->sortByDesc('size')->pluck('size');
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

        }

        if ($orderTotal !== 0) {
            $requiredPackSizes[] = $packSizes->last();
        }

        return array_count_values($requiredPackSizes);
    }
}
