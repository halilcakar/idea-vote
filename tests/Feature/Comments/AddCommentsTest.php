<?php

namespace Tests\Feature\Comments;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Idea;
use App\Models\Comment;
use App\Http\Livewire\AddComment;

class AddCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function add_comment_livewire_component_renders()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSeeLivewire('add-comment');
    }

    /** @test */
    public function add_comment_form_renders_when_user_logged_in()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('idea.show', $idea));

        $response->assertSee('Share your thoughts');
    }

    /** @test */
    public function add_comment_form_does_not_render_when_user_not_logged_in()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee('Please login or create an account to post a comment.');
    }

    /** @test */
    public function add_comment_form_validation_works()
    {
        $idea = Idea::factory()->create();

        $user = $idea->user;

        Livewire::actingAs($user)
            ->test(AddComment::class, ['idea' => $idea])
            ->set('comment', '')
            ->call('addComment')
            ->assertHasErrors(['comment'])
            ->set('comment', 'abc')
            ->call('addComment')
            ->assertHasErrors(['comment']);
    }

    /** @test */
    public function add_comment_form_works()
    {
        $idea = Idea::factory()->create();

        $user = $idea->user;

        Livewire::actingAs($user)
            ->test(AddComment::class, ['idea' => $idea])
            ->set('comment', 'This is my first comment.')
            ->call('addComment')
            ->assertEmitted('commentWasAdded');

        $this->assertEquals(1, Comment::count());
        $this->assertEquals('This is my first comment.', $idea->comments->first()->body);
    }
}
