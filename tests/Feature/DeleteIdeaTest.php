<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Idea;
use App\Http\Livewire\IdeaShow;
use App\Http\Livewire\DeleteIdea;

class DeleteIdeaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function shows_delete_idea_livewire_component_when_user_has_authorization()
    {
        $idea = Idea::factory()->create();

        $user = $idea->user;

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('delete-idea');
    }

    /** @test */
    public function does_not_shows_delete_idea_livewire_component_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('delete-idea');
    }

    /** @test */
    public function deleting_an_idea_with_votes_works_when_user_is_admin()
    {
        $user = User::factory()->admin()->create();

        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(DeleteIdea::class, ['idea' => $idea])
            ->call('deleteIdea')
            ->assertRedirect(route('idea.index'));

        $this->assertDatabaseMissing(
            'ideas',
            $idea->get(['title', 'description', 'user_id', 'status_id', 'category_id'])->toArray()
        );
        $this->assertDatabaseCount('ideas', 0);
    }

    /** @test */
    public function deleting_an_idea_with_votes_works_when_user_has_authorization()
    {
        $idea = Idea::factory()->create();

        $user = $idea->user;

        $idea->vote($user);

        Livewire::actingAs($user)
            ->test(DeleteIdea::class, ['idea' => $idea])
            ->call('deleteIdea')
            ->assertRedirect(route('idea.index'));

        $this->assertDatabaseMissing(
            'ideas',
            $idea->get(['title', 'description', 'user_id', 'status_id', 'category_id'])->toArray()
        );
        $this->assertDatabaseCount('ideas', 0);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id,
        ]);
        $this->assertDatabaseCount('votes', 0);
    }

    /** @test */
    public function deleting_an_idea_shows_on_menu_when_user_is_admin()
    {
        $idea = Idea::factory()->create();

        $user = User::factory()->admin()->create();

        Livewire::actingAs($user)
            ->test(IdeaShow::class, ['idea' => $idea, 'votesCount' => 5])
            ->assertSee('Delete Idea');
    }

    /** @test */
    public function deleting_an_idea_shows_on_menu_when_user_has_authorization()
    {
        $idea = Idea::factory()->create();

        $user = $idea->user;

        Livewire::actingAs($user)
            ->test(IdeaShow::class, ['idea' => $idea, 'votesCount' => 5])
            ->assertSee('Delete Idea');
    }

    /** @test */
    public function deleting_an_idea_does_not_show_on_menu_when_user_has_does_not_have_authorization()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(IdeaShow::class, ['idea' => $idea, 'votesCount' => 5])
            ->assertDontSee('Delete Idea');
    }
}
