<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_count_of_each_status()
    {
        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);
        $statusOpenInProgress = Status::factory()->create(['name' => 'In Progress']);
        $statusImplemented = Status::factory()->create(['name' => 'Implemented']);
        $statusClosed = Status::factory()->create(['name' => 'Closed']);

        Idea::factory()->createMany([
            ['status_id' => $statusOpen->id],
            ['status_id' => $statusConsidering->id],
            ['status_id' => $statusConsidering->id],
            ['status_id' => $statusOpenInProgress->id],
            ['status_id' => $statusOpenInProgress->id],
            ['status_id' => $statusOpenInProgress->id],
            ['status_id' => $statusImplemented->id],
            ['status_id' => $statusImplemented->id],
            ['status_id' => $statusImplemented->id],
            ['status_id' => $statusImplemented->id],
            ['status_id' => $statusClosed->id],
            ['status_id' => $statusClosed->id],
            ['status_id' => $statusClosed->id],
            ['status_id' => $statusClosed->id],
            ['status_id' => $statusClosed->id],
        ]);


        $this->assertEquals(15, Status::getCounts()['all_statuses']);
        $this->assertEquals(1, Status::getCounts()['open']);
        $this->assertEquals(2, Status::getCounts()['considering']);
        $this->assertEquals(3, Status::getCounts()['in_progress']);
        $this->assertEquals(4, Status::getCounts()['implemented']);
        $this->assertEquals(5, Status::getCounts()['closed']);
    }
}
