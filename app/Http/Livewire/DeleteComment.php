<?php

namespace App\Http\Livewire;

use Symfony\Component\HttpFoundation\Response;
use Livewire\Component;
use App\Models\Comment;

class DeleteComment extends Component
{
    public Comment $comment;

    protected $listeners = ['setDeleteComment'];

    public function setDeleteComment($commentId)
    {
        $this->comment = Comment::findOrFail($commentId);

        $this->emit('deleteCommentWasSet');
    }

    public function deleteComment()
    {
        // Authorization
        if (auth()->guest() || auth()->user()->cannot('delete', $this->comment)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        Comment::destroy($this->comment->id);

        $this->emit('commentWasDeleted', 'Comment was deleted!');
    }

    public function render()
    {
        return view('livewire.delete-comment');
    }
}
