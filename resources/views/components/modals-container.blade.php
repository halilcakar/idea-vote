@auth
  @can('update', $idea)
  <livewire:edit-idea :idea="$idea" />
  @endcan

  @can('delete', $idea)
  <livewire:delete-idea :idea="$idea" />
  @endcan

  <livewire:mark-idea-as-spam :idea="$idea" />

  @admin
  <livewire:mark-idea-as-not-spam :idea="$idea" />
  @endadmin

  <livewire:edit-comment />

  <livewire:delete-comment />

  <livewire:mark-comment-as-spam />

  @admin
  <livewire:mark-comment-as-not-spam />
  @endadmin
@endauth
