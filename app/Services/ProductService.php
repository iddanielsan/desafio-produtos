<?php

namespace App\Services;

use App\Contracts\ProductServiceContract;
use Illuminate\Database\Eloquent\Model;

class ProductService implements ProductServiceContract {
    public function __construct(private readonly Model $productModel)
    {
    }

    public function getAllProducts(array $filters): array {
        return $this->productModel->query()
            ->when(isset($filters['name']), fn($query, $name) => $query->where('name', 'like', "%$name%"))
            ->when(isset($filters['price']), fn($query, $price) => $query->where('price', $price))
            ->get()->toArray();
    }

    public function createProduct(array $params): Model {
        $product = $this->productModel->create($params);
        return $product;
    }

    public function updateProduct(Model $product, array $params): Model {
        $product->update($params);
        $product->refresh();
        return $product;
    }

    public function deleteProduct(Model $product): bool {
        return $product->delete();
    }

    public function getProduct(Model $product): Model {
        return $product;
    }
}
