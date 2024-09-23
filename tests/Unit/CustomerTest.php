<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_fillable()
    {
        $customer = new \App\Models\Customer();
        $this->assertEquals([
            'user_id',
            'date_of_birth',
            'address',
            'complement',
            'city',
            'state',
            'zip',
        ], $customer->getFillable());
    }
}
