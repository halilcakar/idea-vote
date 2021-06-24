<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_ideas_shows_on_main_page()
    {
        $user = User::factory()->create();
        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);

        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);
        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $categoryTwo = Category::factory()->create([
            'name' => 'Category 2',
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My second idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
            'description' => 'Description of my second idea',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        // $response->assertSee('<div\n class="200 relative bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">Open</div>', false);

        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
        // $response->assertSee('<div class="bg-purple text-white relative bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">Considering</div>', false);
    }

    /** @test */
    public function single_idea_shows_on_show_page()
    {
        $user = User::factory()->create();

        $status = Status::factory()->create(['name' => 'In Progress', 'classes' => 'bg-yellow text-white']);

        $category = Category::factory()->create([
            'name' => 'Category 1',
        ]);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My first idea',
            'category_id' => $category->id,
            'status_id' => $status->id,
            'description' => 'Description of my first idea',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
        // $response->assertSee('<div class="bg-yellow text-white relative bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">In Progress</div>', false);

    }

    /** @test */
    public function ideas_pagination_works()
    {
        $user = User::factory()->create();

        $status = Status::factory()->create(['name' => 'In Progress', 'classes' => 'bg-yellow text-white']);

        $category = Category::factory()->create([
            'name' => 'Category 1',
        ]);

        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
            'user_id' => $user->id,
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
        $user = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);

        $status = Status::factory()->create(['name' => 'In Progress', 'classes' => 'bg-yellow text-white']);

        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $category->id,
            'description' => 'Description of my first idea',
        ]);
        $ideaTwo = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'status_id' => $status->id,
            'category_id' => $category->id,
            'description' => 'Description of my second idea',
        ]);

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
        $user = User::factory()->create();
        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);

        $categoryOne = Category::factory()->create([ 'name' => 'Category 1' ]);
        $categoryTwo = Category::factory()->create([ 'name' => 'Category 2' ]);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $url = '/?category=Category%202&status=Considering';

        $this->get($url);
        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertStringContainsString($url, $response['backUrl']);
    }

    /** @test */
    public function inn_app_back_button_works_when_show_page_only_page_visited()
    {
        $user = User::factory()->create();
        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);

        $categoryOne = Category::factory()->create([ 'name' => 'Category 1' ]);
        $categoryTwo = Category::factory()->create([ 'name' => 'Category 2' ]);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea',
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertStringContainsString(route('idea.index'), $response['backUrl']);
    }
}
