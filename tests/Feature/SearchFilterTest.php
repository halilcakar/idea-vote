<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function searching_works_when_more_then_3_characters()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $status = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea'
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea'
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Third Idea'
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('search', 'Second')
            ->assertViewHas('ideas', fn($ideas): bool =>
                $ideas->count() === 1 &&
                $ideas->first()->title === 'My Second Idea'
            );
    }

    /** @test */
    public function does_not_perform_search_if_less_then_3_characters()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $status = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea'
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea'
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Third Idea'
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('search', 'as')
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 3);
    }

    /** @test */
    public function search_works_correctly_with_category_filters()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $status = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea'
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea'
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryTwo->id,
            'title' => 'My Third Idea'
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->set('search', 'Idea')
            ->assertViewHas('ideas', fn($ideas): bool => $ideas->count() === 2);
    }
}
