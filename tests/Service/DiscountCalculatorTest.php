<?php

namespace App\Tests\Service;

use App\Service\DiscountCalculator;
use PHPUnit\Framework\TestCase;

class DiscountCalculatorTest extends TestCase
{
    private DiscountCalculator $discountCalculator;

    protected function setUp(): void
    {
        $this->discountCalculator = new DiscountCalculator();
    }

    // V  rifie qu'aucune remise n'est appliqu  e si le montant est inf  rieur ou   gal    100  ^b
    public function testNoDiscountForSmallAmount(): void
    {
        $discount = $this->discountCalculator->calculateDiscount(50.0, false);
        $this->assertEquals(0.0, $discount);
    }

    // V  rifie qu'une remise de 10 % est appliqu  e si le montant est sup  rieur    100  ^b
    public function testBaseDiscountForLargeAmount(): void
    {
        $discount = $this->discountCalculator->calculateDiscount(150.0, false);
        $this->assertEquals(15.0, $discount); // 10% de 150  ^b
    }

    // V  rifie qu'une remise suppl  mentaire de 5 % est appliqu  e pour les clients VIP
    public function testVipDiscount(): void
    {
        $discount = $this->discountCalculator->calculateDiscount(150.0, true);
        $this->assertEquals(22.5, $discount); // 10% + 5% de 150  ^b
    }

    // V  rifie que la remise totale ne d  passe pas 20 % du montant total
    public function testMaxDiscount(): void
    {
        $discount = $this->discountCalculator->calculateDiscount(1000.0, true);
        $this->assertEquals(150.0, $discount); // 10% + 5% de 1000  ^b  (ne d  passe pas 20%)
    }

    // V  rifie le comportement    la limite (montant exactement   gal    100  ^b )
    public function testEdgeCaseExactly100(): void
    {
        $discount = $this->discountCalculator->calculateDiscount(100.0, false);
        $this->assertEquals(0.0, $discount); // Pas de remise    exactement 100  ^b
    }

    // V  rifie le comportement juste au-dessus de 100  ^b
    public function testEdgeCaseJustAbove100(): void
    {
        $discount = $this->discountCalculator->calculateDiscount(100.01, false);
        $this->assertEqualsWithDelta(10.001, $discount, 0.0001); // Tol  rance de 0.0001
    }
}
