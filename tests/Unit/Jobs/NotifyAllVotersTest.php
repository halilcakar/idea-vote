<?php

namespace Tests\Unit\Jobs;

use App\Jobs\NotifyAllVoters;
use App\Mail\IdeaStatusUpdatedMailable;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NotifyAllVotersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_an_email_to_all_voters()
    {
        $user = User::factory()->create(['email' => 'hcakar.1992@gmail.com']);
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Vote::factory()->create(['idea_id' => $idea->id, 'user_id' => $user->id]);
        Vote::factory()->create(['idea_id' => $idea->id, 'user_id' => $userB->id]);

        Mail::fake();

        NotifyAllVoters::dispatch($idea);

        Mail::assertQueued(
            IdeaStatusUpdatedMailable::class,
            fn ($mail): bool => ($mail->hasTo($user->email)
                && $mail->build()->subject === 'An idea you voted for has a new status!')
        );

        Mail::assertQueued(
            IdeaStatusUpdatedMailable::class,
            fn ($mail): bool => ($mail->hasTo($userB->email)
                && $mail->build()->subject === 'An idea you voted for has a new status!')
        );
    }
}
