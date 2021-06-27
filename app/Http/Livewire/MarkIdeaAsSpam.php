<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Response;
use App\Models\Idea;

class MarkIdeaAsSpam extends Component
{
    public Idea $idea;

    public function markAsSpam()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->idea->increment('spam_reports');

        $this->emit('ideaWasMarkedAsSpam');
    }

    public function render()
    {
        return view('livewire.mark-idea-as-spam');
    }
}
