<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_fillable()
    {
        $product = new \App\Models\Product();
        $this->assertEquals(['name', 'price', 'photo'], $product->getFillable());
    }
}
