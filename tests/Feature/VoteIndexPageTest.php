<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VoteIndexPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_page_contains_idea_index_livewire_component()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);

        $status = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $category->id,
            'description' => 'Description of my first idea',
        ]);

        $this->get(route('idea.index'))
            ->assertSeeLivewire('idea-index');
    }


    /** @test */
    public function index_page_correctly_receives_votes_counts()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);

        $status = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $category->id,
            'description' => 'Description of my first idea',
        ]);

        Vote::factory()->create(['idea_id' => $idea->id, 'user_id' => $user->id]);
        Vote::factory()->create(['idea_id' => $idea->id, 'user_id' => $userB->id]);

        $this->get(route('idea.index'))
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->first()->votes_count == 2;
            });
    }

    /** @test */
    public function votes_count_shows_correctly_on_index_page_livewire_component()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);

        $status = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $category->id,
            'description' => 'Description of my first idea',
        ]);

        Livewire::test(IdeaIndex::class, [
            'idea' => $idea,
            'votesCount' => 5,
        ])
            ->assertSet('votesCount', 5)
            ->assertSeeHtml('<div class="font-semibold text-2xl">5</div>')
            ->assertSeeHtml('<div class="text-sm font-bold leading-none">5</div>');
    }
}
