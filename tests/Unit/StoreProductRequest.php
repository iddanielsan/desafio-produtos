<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class StoreProductRequest extends TestCase
{
    public function test_request()
    {
        $request = new \App\Http\Requests\StoreProductRequest();
        $this->assertEquals(['name', 'price', 'photo'], $request->rules()['store']);
    }
}
