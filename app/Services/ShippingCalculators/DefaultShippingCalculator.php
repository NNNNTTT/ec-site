<?php

namespace App\Services\ShippingCalculators;

use App\Interfaces\ShippingCalculatorInterface;

class DefaultShippingCalculator implements ShippingCalculatorInterface
{
    /**
     * @var int 送料無料になる合計金額のしきい値
     */
    private const FREE_SHIPPING_THRESHOLD = 5000; // 例: 5000円以上で送料無料

    /**
     * @var int 通常の一律送料
     */
    private const DEFAULT_FEE = 500; // 例: 一律500円

    /**
     * 注文合計金額に基づいて送料を計算する
     *
     * @param int $totalPrice 注文の合計金額
     * @return int 計算された送料
     */
    public function calculate(int $totalPrice): int
    {
        // もし合計金額が、送料無料になるしきい値以上であれば
        if ($totalPrice >= self::FREE_SHIPPING_THRESHOLD) {
            return 0; // 送料無料
        }

        // しきい値未満であれば、通常の一律送料を返す
        return self::DEFAULT_FEE;
    }
}