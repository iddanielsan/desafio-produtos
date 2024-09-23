<?php

namespace App\Services;

use App\Contracts\CustomerServiceContract;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CustomerService implements CustomerServiceContract {
    public function __construct(private Model $customerModel)
    {
    }

    public function createCustomer(array $data): Customer
    {
        if (!isset($data['user'])) {
            throw new \InvalidArgumentException('User data is required');
        }

        $user = $this->customerModel->user()->create($data['user']);

        return $this->customerModel->create([
            'user_id' => $user->id,
            'date_of_birth' => $data['date_of_birth'],
            'address' => $data['address'],
            'complement' => $data['complement'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
        ]);
    }

    public function updateCustomer(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function getAllCustomers(): Collection
    {
        return $this->customerModel->query()->get();
    }

    public function deleteCustomer(Customer $customer): bool
    {
        return $customer->delete();
    }
}
