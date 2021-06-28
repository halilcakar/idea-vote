<?php

namespace Tests\Feature\Comments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Idea;
use App\Models\Comment;

class ShowCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function idea_comments_livewire_component_renders()
    {
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response
            ->assertSeeLivewire('idea-comments')
            ->assertSee($comment->body);
    }

    /** @test */
    public function idea_comment_livewire_component_renders()
    {
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id
        ]);

        $response = $this->get(route('idea.show', $idea));
        $response
            ->assertSeeLivewire('idea-comment')
            ->assertSee($comment->body);
    }

    /** @test */
    public function no_comments_shows_appropriate_message()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee('No comments yet');
    }

    /** @test */
    public function list_of_comments_shows_on_idea_page()
    {
        $idea = Idea::factory()->create();

        [$one, $two] = Comment::factory(2)->create(['idea_id' => $idea->id]);

        $response = $this->get(route('idea.show', $idea));

        $response
            ->assertSeeInOrder([$one->body, $two->body])
            ->assertSee('2 Comments');
    }

    /** @test */
    public function comments_count_shows_correctly_on_index_page()
    {
        $idea = Idea::factory()->create();

        Comment::factory(2)->create(['idea_id' => $idea->id]);

        $response = $this->get(route('idea.index'));

        $response->assertSee('2 Comments');
    }

    /** @test */
    public function op_badge_shows_if_author_of_idea_comments_on_idea()
    {
        $idea = Idea::factory()->create();

        Comment::factory(2)->create(['idea_id' => $idea->id]);

        Comment::factory()->create(['idea_id' => $idea->id, 'user_id' => $idea->user->id]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee('OP');
    }

    /** @test */
    public function comments_pagination_works()
    {
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea
        ]);

        Comment::factory($comment->getPerPage())->create([
            'idea_id' => $idea
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee($comment->body);
        $response->assertDontSee(Comment::find(Comment::count())->body);

        $response = $this->get(route('idea.show', [
            'idea' => $idea,
            'page' => 2
        ]));

        $response->assertDontSee($comment->body);
        $response->assertSee(Comment::find(Comment::count())->body);
    }
}
