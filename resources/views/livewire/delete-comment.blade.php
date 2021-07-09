<x-modal-confirm
  {{-- event-to-open-modal="custom-show-delete-modal" --}}
  livewire-event-to-open-modal="deleteCommentWasSet"
  event-to-close-modal="commentWasDeleted"
  modal-title="Delete Comment"
  modal-description="Are you sure you want to delete this com ment? This action cannot be undone."
  modal-confirm-button-text="Delete"
  wire-click="deleteComment"
/>
