<?php

namespace Tests\Unit\Services;

use App\Facades\Repository\Command\CommandCategoryRepository;
use App\Jobs\Category\PublishCategoryCreated;
use App\Models\Command\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    public function testServiceStoreCategory()
    {
        // Arrange
        $data = [
            'name' => 'Test Category',
        ];

        $mockCategory = new Category();
        $mockCategory->name = $data['name'];

        $categoryServiceMock = Mockery::mock('alias:'.CommandCategoryRepository::class);
        $categoryServiceMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($mockCategory);

        Bus::fake();

        $service = new CategoryService();

        // Act
        $result = $service->store($data);

        // Assert
        $this->assertEquals($data['name'], $result['name']);

        Bus::assertDispatched(PublishCategoryCreated::class, function ($job) use ($mockCategory) {
            return $job->category['name'] === $mockCategory['name'];
        });
    }
}
