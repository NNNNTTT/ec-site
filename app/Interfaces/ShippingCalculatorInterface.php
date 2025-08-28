<?php

namespace App\Interfaces;

interface ShippingCalculatorInterface
{
    /**
     * 注文情報に基づいて送料を計算する
     *
     * @param int $totalPrice 注文合計金額
     * @return int 計算された送料
     */
    public function calculate(int $totalPrice): int;
}