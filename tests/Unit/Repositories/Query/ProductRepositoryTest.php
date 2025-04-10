<?php

namespace Tests\Unit\Repositories\Query;

use App\Models\Query\Category;
use App\Models\Query\Product;
use App\Repositories\Query\ProductRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $connectionsToTransact = ['mysql_query'];

    protected function setUp(): void
    {
        parent::setUp();

        // Set default connection to mysql_query
        config()->set('database.default', 'mysql_query');
    }

    public function testGetListProduct()
    {
        // Arrange
        $category = Category::create([
            'id' => Uuid::uuid4(),
            'name' => 'Electronics',
            'createdAt' => Carbon::now()->getPreciseTimestamp(3),
        ]);

        for ($i = 1; $i <= 5; $i++) {
            Product::create([
                'id' => Uuid::uuid4(),
                'sku' => 'SKU-' . $i,
                'name' => 'Product ' . $i,
                'price' => 10000 * $i,
                'stock' => 10 * $i,
                'categoryId' => $category->id,
                'createdAt' => Carbon::now()->getPreciseTimestamp(3),
            ]);
        }

        $repository = new ProductRepository();

        $conditions = [
            ['products.categoryId', '=', $category->id]
        ];
        $pagging = [
            'size' => 2,
            'current' => 1
        ];

        // Act
        $result = $repository->getList($conditions, $pagging);

        // Assert
        $this->assertArrayHasKey('datas', $result);
        $this->assertArrayHasKey('pagging', $result);

        $this->assertCount(2, $result['datas']); // Size = 2
        $this->assertEquals(5, $result['pagging']['total']); // Insert 5 product

        $firstProduct = $result['datas']->first();
        $this->assertArrayHasKey('category', $firstProduct);
        $this->assertEquals('Electronics', $firstProduct['category']['name']);
    }
}
