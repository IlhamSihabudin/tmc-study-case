<?php

namespace Tests\Feature;

use App\Facades\Service\ProductService;
use App\Models\Command\Category;
use App\Models\Command\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    // Start::Store Product
    public function testStoreProductInvalidApiKey()

    {
        // Arrange
        $requestData = [
            'sku' => 'SKU001',
            'name' => 'Buku',
            'price' => 1000000,
            'stock' => 100,
            'categoryId' => '7d3a984c-d21d-4ba5-aec6-47f7bc9d13db',
        ];

        // Act
        $response = $this->postJson(route('products.store'), $requestData);

        // Assert
        $response->assertStatus(401);
        $response->assertJson([
            'errors' => 'Unauthorized. Your API key is invalid',
        ]);
    }

    public function testStoreProductSuccess()
    {
        // Arrange
        $requestData = [
            'sku' => 'SKU001',
            'name' => 'Buku',
            'price' => 1000000,
            'stock' => 100,
            'categoryId' => '7d3a984c-d21d-4ba5-aec6-47f7bc9d13db',
        ];

        $dummyCategory = new Category();
        $dummyCategory->id = '7d3a984c-d21d-4ba5-aec6-47f7bc9d13db';
        $dummyCategory->name = 'Test Category';
        $dummyCategory->createdAt = Carbon::now()->getPreciseTimestamp(3);
        $dummyCategory->save();

        $mockProductModel = new Product();
        $mockProductModel->id = '0f56641d-c5fd-4938-8a56-45ffb194f493';
        $mockProductModel->sku = 'SKUTEST001';
        $mockProductModel->name = 'Buku';
        $mockProductModel->price = 1000000;
        $mockProductModel->stock = 100;
        $mockProductModel->categoryId = $dummyCategory->id;
        $mockProductModel->category = [
            'id' => $dummyCategory->id,
            'name' => $dummyCategory->name,
        ];
        $mockProductModel->createdAt = Carbon::now()->getPreciseTimestamp(3);

        // Mock the ProductService
        $productServiceMock = Mockery::mock('alias:'.ProductService::class);
        $productServiceMock->shouldReceive('store')
            ->once()
            ->with($requestData)
            ->andReturn($mockProductModel);

        $this->app->instance(ProductService::class, $productServiceMock);

        // Act
        $response = $this->withHeader('Authorization', self::API_KEY)
            ->postJson(route('products.store'), $requestData);

        // Assert
        $response->assertStatus(200);

        $this->assertEquals($mockProductModel->id, $response['data']['id']);
        $this->assertEquals($mockProductModel->sku, $response['data']['sku']);
        $this->assertEquals($mockProductModel->name, $response['data']['name']);
        $this->assertEquals($mockProductModel->price, $response['data']['price']);
        $this->assertEquals($mockProductModel->stock, $response['data']['stock']);
        $this->assertEquals($mockProductModel->category, $response['data']['category']);
        $this->assertEquals($mockProductModel->createdAt, $response['data']['createdAt']);
    }

    public function testStoreCategoryHandlesException()
    {
        // Arrange
        $requestData = [
            'sku' => 'SKU001',
            'name' => 'Buku',
            'price' => 1000000,
            'stock' => 100,
            'categoryId' => '7d3a984c-d21d-4ba5-aec6-47f7bc9d13db',
        ];

        $dummyCategory = new Category();
        $dummyCategory->id = '7d3a984c-d21d-4ba5-aec6-47f7bc9d13db';
        $dummyCategory->name = 'Test Category';
        $dummyCategory->createdAt = Carbon::now()->getPreciseTimestamp(3);
        $dummyCategory->save();

        $mockProductModel = new Product();
        $mockProductModel->id = '0f56641d-c5fd-4938-8a56-45ffb194f493';
        $mockProductModel->sku = 'SKUTEST001';
        $mockProductModel->name = 'Buku';
        $mockProductModel->price = 1000000;
        $mockProductModel->stock = 100;
        $mockProductModel->categoryId = $dummyCategory->id;
        $mockProductModel->category = [
            'id' => $dummyCategory->id,
            'name' => $dummyCategory->name,
        ];
        $mockProductModel->createdAt = Carbon::now()->getPreciseTimestamp(3);

        // Mock the ProductService to throw an exception
        $productServiceMock = Mockery::mock('alias:'.ProductService::class);
        $productServiceMock->shouldReceive('store')
            ->once()
            ->with($requestData)
            ->andThrow(new \Exception('Something went wrong'));

        $this->app->instance(ProductService::class, $productServiceMock);

        // Act
        $response = $this->withHeader('Authorization', self::API_KEY)
            ->postJson(route('products.store'), $requestData);

        // Assert
        $response->assertStatus(400);
        $response->assertJson([
            'errors' => 'Something went wrong',
        ]);
    }
    // End::Store Product

    // Start::List Product
    public function testListProductSuccess()
    {
        // Arrange
        $mockedData = [
            "data" => [
                [
                    "id" => "62f81b9d-826a-44f3-8266-a767ded63991",
                    "sku" => "SKU002",
                    "name" => "Meja",
                    "price" => 400000,
                    "stock" => 50,
                    "category" => [
                        "id" => "6aa25132-12b9-4bac-a468-6d73c192c3ff",
                        "name" => "Category 2",
                    ],
                    "createdAt" => 1744290681140,
                ],
                [
                    "id" => "6c935756-df86-496c-a26a-cb95f4ff5e95",
                    "sku" => "SKU001",
                    "name" => "Buku",
                    "price" => 20000,
                    "stock" => 100,
                    "category" => [
                        "id" => "97167983-3160-4ffc-8e5b-af3654b42d46",
                        "name" => "Category 1",
                    ],
                    "createdAt" => 1744290639235,
                ],
            ],
            "pagging" => ["size" => 10, "current" => 1, "total" => 2],
        ];

        // Mock the ProductService
        $productServiceMock = Mockery::mock('alias:'.ProductService::class);
        $productServiceMock->shouldReceive('search')
            ->once()
            ->andReturn([
                'datas' => $mockedData['data'],
                'pagging' => $mockedData['pagging'],
            ]);

        // Act
        $response = $this->withHeader('Authorization', self::API_KEY)
            ->getJson(route('products.search'));

        // Assert
        $response->assertStatus(200);
        $response->assertJson($mockedData);
    }
    // End::List Product
}
