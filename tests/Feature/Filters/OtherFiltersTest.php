<?php

namespace Tests\Feature\Filters;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OtherFiltersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function top_voted_filter_works()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();
        $userC = User::factory()->create();

        $categoryOne = Category::factory()->create();

        $status = Status::factory()->create();

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
        ]);

        Vote::factory()->create(['idea_id' => $ideaOne->id, 'user_id' => $user->id]);
        Vote::factory()->create(['idea_id' => $ideaOne->id, 'user_id' => $userB->id]);
        Vote::factory()->create(['idea_id' => $ideaTwo->id, 'user_id' => $userC->id]);

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'Top Voted')
            ->assertViewHas(
                'ideas',
                fn ($ideas): bool =>
                $ideas->count() === 2 &&
                    $ideas->first()->votes()->count() === 2 &&
                    $ideas->get(1)->votes()->count() === 1
            );
    }

    /** @test */
    public function my_ideas_filter_works_correctly_when_user_logged_in()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea'
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea'
        ]);
        Idea::factory()->create([
            'user_id' => $userB->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Third Idea'
        ]);

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('filter', 'My Ideas')
            ->assertViewHas(
                'ideas',
                fn ($ideas): bool =>
                $ideas->count() === 2 &&
                    $ideas->first()->title === 'My Second Idea' &&
                    $ideas->get(1)->title === 'My First Idea'
            );
    }

    /** @test */
    public function my_ideas_filter_works_correctly_when_user_is_not_logged_in()
    {
        Idea::factory(3)->create();

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'My Ideas')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function my_ideas_filter_works_correctly_with_categories_filter()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea'
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea'
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryTwo->id,
            'title' => 'My Third Idea'
        ]);

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('filter', 'My Ideas')
            ->set('category', 'Category 1')
            ->assertViewHas(
                'ideas',
                fn ($ideas): bool =>
                $ideas->count() === 2 &&
                    $ideas->first()->title === 'My Second Idea' &&
                    $ideas->get(1)->title === 'My First Idea'
            );
    }

    /** @test */
    public function no_filters_works_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $status = Status::factory()->create(['name' => 'Open']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea'
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea'
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Third Idea'
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'No Filter')
            ->assertViewHas(
                'ideas',
                fn ($ideas): bool =>
                $ideas->count() === 3 &&
                    $ideas->first()->title === 'My Third Idea' &&
                    $ideas->get(1)->title === 'My Second Idea'
            );
    }
}