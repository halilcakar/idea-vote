<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaIndex;
use App\Http\Livewire\IdeaShow;
use App\Http\Livewire\IdeasIndex;
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
    public function ideas_index_livewire_component_correctly_receives_votes_counts()
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

        Livewire::test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->first()->votes_count == 2;
            });

        // $this->get(route('idea.index'))
        //     ->assertViewHas('ideas', function ($ideas) {
        //         return $ideas->first()->votes_count == 2;
        //     });
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
            ->assertSeeHtml('<div class="font-semibold text-2xl ">5</div>')
            ->assertSeeHtml('<div class="text-sm font-bold leading-none ">5</div>');
    }

    /** @test */
    public function user_who_is_logged_in_shows_voted_if_idea_already_voted_for()
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

        Vote::factory()->create(['idea_id' => $idea->id, 'user_id' => $user->id]);

        $idea->votes_count = 1;
        $idea->voted_by_user = 1;

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 5,
            ])
            ->assertSet('hasVoted', true)
            ->assertSee('Voted');
    }

    /** @test */
    public function user_who_is_not_logged_in_is_redirected_to_login_page_when_trying_to_vote()
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

        Livewire::test(IdeaShow::class, [
            'idea' => $idea,
            'votesCount' => 5,
        ])
            ->call('vote')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_who_is_logged_in_can_vote_and_remove_vote_for_idea()
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

        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id
        ]);

        $LivewireComponent = Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 5,
            ])
            ->call('vote')
            ->assertSet('votesCount', 6)
            ->assertSet('hasVoted', true)
            ->assertSee('Voted');

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id
        ]);

        $LivewireComponent->call('vote')
            ->assertSet('votesCount', 5)
            ->assertSet('hasVoted', false)
            ->assertSee('Vote');
    }
}
