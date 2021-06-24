<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryFiltersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function selecting_a_category_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $status = Status::factory()->create(['name' => 'Open']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 2)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->first()->category->name === 'Category 1')
            ->set('category', 'Category 2')
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 1)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->first()->category->name === 'Category 2');
    }

    /** @test */
    public function the_category_query_string_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $status = Status::factory()->create(['name' => 'Open']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::withQueryParams(['category' => 'Category 1'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 2)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->first()->category->name === 'Category 1');
    }

    /** @test */
    public function selecting_a_status_and_a_category_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusOpen->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusConsidering->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusOpen->id,
            'category_id' => $categoryTwo->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusConsidering->id,
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('status', 'Open')
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 1)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->first()->category->name === 'Category 1')
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->first()->status->name === 'Open');
    }

    /** @test */
    public function the_category_query_string_filters_correctly_with_status_and_category()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusOpen->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusConsidering->id,
            'category_id' => $categoryOne->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusOpen->id,
            'category_id' => $categoryTwo->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $statusConsidering->id,
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::withQueryParams([
            'status' => 'Open',
            'category' => 'Category 1',
        ])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 1)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->first()->category->name === 'Category 1')
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->first()->status->name === 'Open');
    }

    /** @test */
    public function selecting_all_category_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $status = Status::factory()->create(['name' => 'Open']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Category'
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Category'
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryTwo->id,
            'title' => 'My Third Category'
        ]);

        Livewire::test(IdeasIndex::class)
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 3);
    }
}
