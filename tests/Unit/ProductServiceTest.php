<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductService;
use Database\Factories\ProductFactory;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_get_all_products_with_filters()
    {
        $productModel = Mockery::mock(Product::class);
        $productModel->shouldReceive('query')->andReturnSelf();
        $productModel->shouldReceive('when')->andReturnSelf();
        $productModel->shouldReceive('get')->andReturn(collect([]));
        $productModel->shouldReceive('toArray')->andReturn([]);

        $productService = new ProductService($productModel);
        $result = $productService->getAllProducts(['name' => 'test', 'price' => 100]);
        $this->assertIsArray($result);
    }

    public function test_create_product()
    {
        $productModel = Mockery::mock(Product::class);
        $productModel->shouldReceive('create')->andReturn(new Product());

        $productService = new ProductService($productModel);
        $result = $productService->createProduct(['name' => 'test', 'price' => 100]);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_update_product()
    {
        $productModel = Mockery::mock(Product::class);
        $productModel->shouldReceive('update')->andReturn(new Product());
        $productModel->shouldReceive('refresh')->andReturn(new Product());

        $productService = new ProductService($productModel);
        $result = $productService->updateProduct(new Product(), ['name' => 'test', 'price' => 100]);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_delete_product()
    {
        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('delete')->once()->andReturn(true);
        $productService = new ProductService(new Product());
        $result = $productService->deleteProduct($productMock);
        $this->assertTrue($result);
    }

    public function test_get_product()
    {
        $productService = new ProductService(new Product());
        $result = $productService->getProduct(new Product());
        $this->assertInstanceOf(Product::class, $result);
    }
}
