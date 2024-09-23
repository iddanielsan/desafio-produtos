<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProductServiceContract {
    public function getAllProducts(array $filters): array;
    public function createProduct(array $params): Model;
    public function updateProduct(Model $product, array $params): Model;
    public function deleteProduct(Model $id): bool;
    public function getProduct(Model $id): Model;
}
