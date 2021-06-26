<?php

namespace Tests\Feature;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Idea;
use App\Models\Category;
use App\Http\Livewire\IdeaShow;
use App\Http\Livewire\EditIdea;

class EditIdeaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function shows_edit_idea_livewire_component_when_user_has_authorization()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('edit-idea');
    }

    /** @test */
    public function does_not_shows_edit_idea_livewire_component_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('edit-idea');
    }

    /** @test */
    public function edit_idea_form_validation_works()
    {
        $idea = Idea::factory()->create();

        $user = $idea->user;

        Livewire::actingAs($user)
            ->test(EditIdea::class, ['idea' => $idea])
            ->set('title', '')
            ->set('category', '')
            ->set('description', '')
            ->call('updateIdea')
            ->assertHasErrors(['title', 'category', 'description'])
            ->assertSee('The title field is required');
    }

    /** @test */
    public function editing_an_idea_works_when_user_has_authorization()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $idea = Idea::factory()->create(['user_id' => $user->id, 'category_id' => $categoryOne->id]);

        Livewire::actingAs($user)
            ->test(EditIdea::class, ['idea' => $idea])
            ->set('title', 'My Edited Idea')
            ->set('category', $categoryTwo->id)
            ->set('description', 'This is my edited idea')
            ->call('updateIdea')
            ->assertEmitted('ideaWasUpdated');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My Edited Idea',
            'category_id' => $categoryTwo->id,
            'description' => 'This is my edited idea',
        ]);
    }

    /** @test */
    public function editing_an_idea_does_not_works_when_user_does_not_have_authorization_because_different_user_created_idea()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $idea = Idea::factory()->create(['category_id' => $categoryOne->id]);

        Livewire::actingAs($user)
            ->test(EditIdea::class, ['idea' => $idea])
            ->set('title', 'My Edited Idea')
            ->set('category', $categoryTwo->id)
            ->set('description', 'This is my edited idea')
            ->call('updateIdea')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function editing_an_idea_does_not_works_when_user_does_not_have_authorization_because_idea_was_created_longer_then_an_hour_ago()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'created_at' => now()->subHours(2)
        ]);

        Livewire::actingAs($user)
            ->test(EditIdea::class, ['idea' => $idea])
            ->set('title', 'My Edited Idea')
            ->set('category', $categoryTwo->id)
            ->set('description', 'This is my edited idea')
            ->call('updateIdea')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function editing_an_idea_shows_on_menu_when_user_has_authorization()
    {
        $idea = Idea::factory()->create();

        $user = $idea->user;

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 5
            ])
            ->assertSee('Edit Idea');
    }

    /** @test */
    public function editing_an_idea_does_not_show_on_menu_when_user_has_does_not_have_authorization()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 5
            ])
            ->assertDontSee('Edit Idea');
    }
}
