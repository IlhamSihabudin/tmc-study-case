<?php

namespace Tests\Unit\Services;

use App\Facades\Repository\Command\CommandProductRepository;
use App\Jobs\Product\PublishProductCreated;
use App\Models\Command\Product;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    public function testServiceStoreProduct()
    {
        // Arrange
        $data = [
            'sku' => 'SKU001',
            'name' => 'Buku',
            'price' => 1000000,
            'stock' => 100,
            'categoryId' => '7d3a984c-d21d-4ba5-aec6-47f7bc9d13db',
        ];

        $dummyCategory = (object) [
            'id' => '7d3a984c-d21d-4ba5-aec6-47f7bc9d13db',
            'name' => 'Test Category'
        ];
        $mockProductModel = new Product();
        $mockProductModel->id = '0f56641d-c5fd-4938-8a56-45ffb194f493';
        $mockProductModel->sku = 'SKU001';
        $mockProductModel->name = 'Buku';
        $mockProductModel->price = 1000000;
        $mockProductModel->stock = 100;
        $mockProductModel->categoryId = $dummyCategory->id;
        $mockProductModel->category = $dummyCategory;
        $mockProductModel->createdAt = Carbon::now()->getPreciseTimestamp(3);

        $categoryServiceMock = Mockery::mock('alias:'.CommandProductRepository::class);
        $categoryServiceMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($mockProductModel);

        Bus::fake();

        $productService = new ProductService();

        // Act
        $result = $productService->store($data);

        // Assert
        $this->assertEquals([
            'id',
            'sku',
            'name',
            'price',
            'stock',
            'category',
            'createdAt',
        ], array_keys($result));

        $this->assertEquals($mockProductModel->id, $result['id']);
        $this->assertEquals($mockProductModel->sku, $result['sku']);
        $this->assertEquals($mockProductModel->name, $result['name']);
        $this->assertEquals($mockProductModel->price, $result['price']);
        $this->assertEquals($mockProductModel->stock, $result['stock']);
        $this->assertEquals($mockProductModel->category, $result['category']);
        $this->assertEquals($mockProductModel->createdAt, $result['createdAt']);

        Bus::assertDispatched(PublishProductCreated::class, function ($job) use ($mockProductModel) {
            return $job->product['sku'] === $mockProductModel->sku;
        });
    }
}
