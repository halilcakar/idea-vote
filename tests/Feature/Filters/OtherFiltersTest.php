<?php

namespace Tests\Feature\Filters;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Vote;
use App\Models\User;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Comment;
use App\Models\Category;
use App\Http\Livewire\IdeasIndex;

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

    /** @test */
    public function spam_ideas_filter_works()
    {
        $user = User::factory()->admin()->create();

        [$ideaOne, $ideaTwo, $ideaThree,] = Idea::factory()->createMany([
            ['title' => 'Idea One', 'spam_reports' => 1],
            ['title' => 'Idea Two', 'spam_reports' => 2],
            ['title' => 'Idea Three', 'spam_reports' => 3],
            []
        ]);

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('filter', 'Spam Ideas')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 3
                    && $ideas->first()->title === 'Idea Three'
                    && $ideas->get(1)->title === 'Idea Two'
                    && $ideas->get(2)->title === 'Idea One';
            });
    }

    /** @test */
    public function spam_comments_filter_works()
    {
        $user = User::factory()->admin()->create();

        $ideaOne = Idea::factory()->create([
            'title' => 'Idea One',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'Idea Two',
        ]);

        $ideaThree = Idea::factory()->create([
            'title' => 'Idea Two',
        ]);

        $commentOne = Comment::factory()->create([
            'idea_id' => $ideaOne->id,
            'body' => 'This is my first comment',
            'spam_reports' => 3,
        ]);

        $commentTwo = Comment::factory()->create([
            'idea_id' => $ideaTwo->id,
            'body' => 'This is my second comment',
            'spam_reports' => 2,
        ]);

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('filter', 'Spam Comments')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2;
            });
    }
}
