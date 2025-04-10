<?php

namespace Tests\Feature;

use App\Facades\Service\CategoryService;
use App\Models\Command\Category;
use Mockery;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testStoreCategoryInvalidApiKey()

    {
        // Arrange
        $requestData = [
            'name' => 'Test Category',
        ];

        // Act
        $response = $this->postJson(route('categories.store'), $requestData);

        // Assert
        $response->assertStatus(401);
        $response->assertJson([
            'errors' => 'Unauthorized. Your API key is invalid',
        ]);
    }

    public function testStoreCategorySuccess()
    {
        // Arrange
        $requestData = [
            'name' => 'Test Category',
        ];

        $mockedCategory = new Category();
        $mockedCategory->name = $requestData['name'];

        // Mock the CategoryService
        $categoryServiceMock = Mockery::mock('alias:'.CategoryService::class);
        $categoryServiceMock->shouldReceive('store')
            ->once()
            ->with($requestData)
            ->andReturn($mockedCategory);

        $this->app->instance(CategoryService::class, $categoryServiceMock);

        // Act
        $response = $this->withHeader('Authorization', self::API_KEY)
            ->postJson(route('categories.store'), $requestData);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $mockedCategory->toArray(),
        ]);
    }

    public function testStoreCategoryHandlesException()
    {
        // Arrange
        $requestData = [
            'name' => 'Test Category',
        ];

        // Mock the CategoryService to throw an exception
        $categoryServiceMock = Mockery::mock('alias:'.CategoryService::class);
        $categoryServiceMock->shouldReceive('store')
            ->once()
            ->with($requestData)
            ->andThrow(new \Exception('Something went wrong'));

        $this->app->instance(CategoryService::class, $categoryServiceMock);

        // Act
        $response = $this->withHeader('Authorization', self::API_KEY)
            ->postJson(route('categories.store'), $requestData);

        // Assert
        $response->assertStatus(400);
        $response->assertJson([
            'errors' => 'Something went wrong',
        ]);
    }
}
