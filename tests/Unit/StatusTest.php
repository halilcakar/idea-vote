<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_count_of_each_status()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);
        $statusOpenInProgress = Status::factory()->create(['name' => 'In Progress', 'classes' => 'bg-yellow text-white']);
        $statusImplemented = Status::factory()->create(['name' => 'Implemented', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        Idea::factory()->create([ 'status_id' => $statusOpen->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusConsidering->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusConsidering->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusOpenInProgress->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusOpenInProgress->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusOpenInProgress->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusImplemented->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusImplemented->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusImplemented->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusImplemented->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusClosed->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusClosed->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusClosed->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusClosed->id, 'user_id' => $user->id, 'category_id' => $category->id ]);
        Idea::factory()->create([ 'status_id' => $statusClosed->id, 'user_id' => $user->id, 'category_id' => $category->id ]);


        $this->assertEquals(15, Status::getCounts()['all_statuses']);
        $this->assertEquals(1, Status::getCounts()['open']);
        $this->assertEquals(2, Status::getCounts()['considering']);
        $this->assertEquals(3, Status::getCounts()['in_progress']);
        $this->assertEquals(4, Status::getCounts()['implemented']);
        $this->assertEquals(5, Status::getCounts()['closed']);
    }
}
