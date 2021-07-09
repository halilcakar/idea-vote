<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;

class IdeaComment extends Component
{
    public Comment $comment;
    public $ideaUserId;

    protected $listeners = ['commentWasUpdated'];

    public function commentWasUpdated()
    {
        $this->comment->refresh();
    }

    public function render()
    {
        return view('livewire.idea-comment', [
            'comment' => $this->comment
        ]);
    }
}
