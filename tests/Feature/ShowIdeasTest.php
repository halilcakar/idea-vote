<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Category;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_ideas_shows_on_main_page()
    {
        [$categoryOne, $categoryTwo] = Category::factory(2)->create();
        [$statusOne, $statusTwo] = Status::factory(2)->create();
        [$ideaOne, $ideaTwo] = Idea::factory()->createMany([
            ['category_id' => $categoryOne->id, 'status_id' => $statusOne->id],
            ['category_id' => $categoryTwo->id, 'status_id' => $statusTwo->id]
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee($statusOne->name);

        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
        $response->assertSee($statusTwo->name);
    }

    /** @test */
    public function single_idea_shows_on_show_page()
    {
        $category = Category::factory()->create();

        $status = Status::factory()->create();

        $idea = Idea::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
        $response->assertSee($status->name);
    }

    /** @test */
    public function ideas_pagination_works()
    {
        $category = Category::factory()->create(['name' => 'Category 1']);

        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id' => $category->id
        ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My first idea';
        $ideaOne->save();

        $ideaEleven = Idea::find(11);
        $ideaEleven->title = 'My eleventh idea';
        $ideaEleven->save();

        $response = $this->get('/');
        $response->assertSee($ideaEleven->title);
        $response->assertDontSee($ideaOne->title);
        $response->assertSee($category->name);

        $response = $this->get('/?page=2');
        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaEleven->title);
        $response->assertSee($category->name);
    }

    /** @test */
    public function same_idea_title_different_slugs()
    {
        [$ideaOne, $ideaTwo] = Idea::factory(2)->create(['title' => 'My first idea']);

        $response = $this->get(route('idea.show', $ideaOne));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea-2');
    }

    /** @test */
    public function inn_app_back_button_works_when_index_page_visited_first()
    {
        $ideaOne = Idea::factory()->create();

        $url = '/?category=Category%202&status=Considering';

        $this->get($url);

        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertStringContainsString($url, $response['backUrl']);
    }

    /** @test */
    public function inn_app_back_button_works_when_show_page_only_page_visited()
    {
        $ideaOne = Idea::factory()->create();

        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertStringContainsString(route('idea.index'), $response['backUrl']);
    }
}
