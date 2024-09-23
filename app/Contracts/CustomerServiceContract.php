<?php

namespace App\Contracts;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

interface CustomerServiceContract
{
    public function getAllCustomers(): Collection;
    public function createCustomer(array $data): Customer;
    public function updateCustomer(Customer $customer, array $data): Customer;
    public function deleteCustomer(Customer $customer): bool;
}
