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
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $idea = Idea::factory()->create();

        Vote::factory()->createMany([
            ['idea_id' => $idea->id, 'user_id' => $user->id],
            ['idea_id' => $idea->id, 'user_id' => $userB->id],
        ]);

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
