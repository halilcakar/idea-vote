<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;

class IdeaComments extends Component
{
    public Idea $idea;

    protected $listeners = [
        'commentWasAdded'
    ];

    public function commentWasAdded()
    {
        $this->idea->refresh();
    }

    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => $this->idea->comments,
            'idea' => $this->idea
        ]);
    }
}
