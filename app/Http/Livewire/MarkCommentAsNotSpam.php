<?php

namespace App\Http\Livewire;

use Symfony\Component\HttpFoundation\Response;
use Livewire\Component;
use App\Models\Comment;

class MarkCommentAsNotSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsNotSpamComment'];

    public function setMarkAsNotSpamComment($commentId)
    {
        $this->comment = Comment::findOrFail($commentId);

        $this->emit('markAsNotSpamCommentWasSet');
    }

    public function markAsNotSpam()
    {
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->comment->decrement('spam_reports', $this->comment->spam_reports);

        $this->emit('commentWasMarkedAsNotSpam', 'Comment spam counter was reset!');
    }

    public function render()
    {
        return view('livewire.mark-comment-as-not-spam');
    }
}
