<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Idea;
use App\Models\Comment;

class IdeaComments extends Component
{
    use WithPagination;

    public Idea $idea;

    protected $listeners = ['commentWasAdded'];

    public function commentWasAdded()
    {
        $this->idea->refresh();

        $this->gotoPage($this->idea->comments()->paginate()->lastPage());
    }

    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => Comment::with('user')
                ->where('idea_id', $this->idea->id)
                ->paginate()
                ->withQueryString(),
            'idea' => $this->idea
        ]);
    }
}
