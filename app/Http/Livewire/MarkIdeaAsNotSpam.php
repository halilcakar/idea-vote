<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Response;
use App\Models\Idea;

class MarkIdeaAsNotSpam extends Component
{
    public Idea $idea;

    public function markAsNotSpam()
    {
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->idea->decrement('spam_reports', $this->idea->spam_reports);

        $this->emit('ideaWasMarkedAsNotSpam', 'Spam Counter was reset to 0.');
    }

    public function render()
    {
        return view('livewire.mark-idea-as-not-spam');
    }
}
