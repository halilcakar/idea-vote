<?php

namespace Tests\Feature\Filters;

use App\Http\Livewire\IdeasIndex;
use App\Http\Livewire\StatusFilters;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StatusFiltersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_page_contains_status_filters_livewire_component()
    {
        Idea::factory(5)->create();

        $this->get(route('idea.index'))
            ->assertSeeLivewire('status-filters');
    }

    /** @test */
    public function show_page_contains_status_filters_livewire_component()
    {
        $idea = Idea::factory()->create();

        $this->get(route('idea.show', $idea))
            ->assertSeeLivewire('status-filters');
    }

    /** @test */
    public function shows_correct_status_count()
    {
        $status = Status::factory()->create([
            'id' => 4,
            'name' => 'Implemented'
        ]);

        Idea::factory(2)->create(['status_id' => $status->id]);

        Livewire::test(StatusFilters::class)
            ->assertSee('All Ideas (2)')
            ->assertSee('Implemented (2)');
    }

    /** @test */
    public function filtering_works_when_query_string_in_place()
    {
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);
        $statusOpenInProgress = Status::factory()->create(['name' => 'In Progress']);

        Idea::factory(2)->create(['status_id' => $statusConsidering->id]);

        Idea::factory(3)->create(['status_id' => $statusOpenInProgress->id]);

        Livewire::withQueryParams(['status' => 'In Progress'])
            ->test(IdeasIndex::class)
            ->assertViewHas(
                'ideas',
                fn ($ideas): bool =>
                $ideas->count() === 3 &&
                    $ideas->first()->status->name === 'In Progress'
            );
    }

    /** @test */
    public function show_page_does_not_show_selected_status()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertDontSee('border-blue text-gray-900');
    }

    /** @test */
    public function index_page_show_selected_status()
    {
        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee('border-blue text-gray-900');
    }
}
