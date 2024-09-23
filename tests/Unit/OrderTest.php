<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function test_fillable()
    {
        $product = new \App\Models\Order();
        $this->assertEquals(['customer_id'], $product->getFillable());
    }
}
