<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Vote;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Category;

class IdeasIndex extends Component
{
    use WithPagination;

    public $status;
    public $category;
    public $filter;
    public $search;

    protected $queryString = [
        'status',
        'category',
        'filter',
        'search',
    ];

    protected $listeners = [
        'queryStringUpdatedStatus'
    ];

    public function mount()
    {
        $this->status = request()->status ?? 'All';
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        if ($this->filter === 'My Ideas' && !auth()->check()) {
            return redirect()->route('login');
        }
    }

    public function queryStringUpdatedStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->resetPage();
    }

    public function render()
    {
        $statuses = Status::all()->pluck('id', 'name');
        $categories = Category::all();

        return view('livewire.ideas-index', [
            'ideas' => Idea::with('user', 'category', 'status')
                ->when(
                    $this->status and $this->status !== 'All',
                    fn ($query) => $query->where('status_id', $statuses->get($this->status))
                )
                ->when(
                    $this->category and $this->category !== 'All Categories',
                    fn ($query) =>
                    $query->where('category_id', $categories->pluck('id', 'name')
                        ->get($this->category))
                )
                ->when(
                    $this->filter and $this->filter === 'Top Voted',
                    fn ($query) => $query->orderByDesc('votes_count')
                )
                ->when(
                    $this->filter and $this->filter === 'My Ideas',
                    fn ($query) => $query->orderByDesc('votes_count')->where('user_id', auth()->id())
                )
                ->when(
                    $this->filter and $this->filter === 'Spam Ideas'
                        && auth()->check() && auth()->user()->isAdmin(),
                    fn ($query) => $query->where('spam_reports', '>', 0)->orderByDesc('spam_reports')
                )
                ->when(
                    strlen($this->search) >= 3,
                    fn ($query) => $query->where('title', 'like', '%' . $this->search . '%')
                )
                ->addSelect([
                    'voted_by_user' => Vote::select('id')
                        ->where('user_id', auth()->id())
                        ->whereColumn('idea_id', 'ideas.id'),
                ])
                ->withCount('votes')
                ->orderBy('id', 'desc')
                ->simplePaginate(Idea::PAGINATION_COUNT),
            'categories' => $categories
        ]);
    }
}
