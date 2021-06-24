<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\Vote;
use Livewire\Component;
use Livewire\WithPagination;
use function PHPUnit\Framework\at;

class IdeasIndex extends Component
{
    use WithPagination;

    public $status;
    public $category;
    public $filter;

    protected $queryString = [
        'status',
        'category',
        'filter'
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

    public function updatedFilter()
    {
        if($this->filter === 'My Ideas' && ! auth()->check()) {
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
                ->when($this->status and $this->status !== 'All', function ($query) use($statuses) {
                    return $query->where('status_id', $statuses->get($this->status));
                })
                ->when($this->category and $this->category !== 'All Categories', function ($query) use($categories) {
                    return $query->where('category_id', $categories->pluck('id', 'name')->get($this->category));
                })
                ->when($this->filter and $this->filter === 'Top Voted', function ($query) {
                    return $query->orderByDesc('votes_count');
                })
                ->when($this->filter and $this->filter === 'My Ideas', function ($query) {
                    return $query->where('user_id', auth()->id());
                })
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
