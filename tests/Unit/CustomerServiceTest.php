<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mockery;
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    public function test_get_all_customers()
    {
        $customerModel = Mockery::mock(Customer::class);
        $customerModel->shouldReceive('query')->andReturnSelf();
        $customerModel->shouldReceive('get')->andReturn(new Collection([]));

        $customerService = new CustomerService($customerModel);
        $result = $customerService->getAllCustomers();
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function test_create_customer()
    {
        $customerModel = Mockery::mock(Customer::class)->makePartial();
        $customerModel->shouldReceive('create')->andReturn(new Customer());
        $customerModel->shouldReceive('user')->andReturnSelf();

        $customerService = new CustomerService($customerModel);
        $result = $customerService->createCustomer([]);
        $this->assertInstanceOf(Customer::class, $result);
    }
}
