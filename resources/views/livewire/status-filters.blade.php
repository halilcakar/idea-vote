<nav class="hidden md:flex items-center justify-between text-gray-400 text-xs">
    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li>
            <a
                href="{{ route('idea.index', ['status' => 'All']) }}"
                wire:click.prevent="setStatus('All')"
                class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'All') border-blue text-gray-900 @endif">
                All Ideas ({{$statusCount['all_statuses']}})
            </a>
        </li>
        <li>
            <a
                href="{{ route('idea.index', ['status' => 'Considering']) }}"
                wire:click.prevent="setStatus('Considering')"
                class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'Considering') border-blue text-gray-900 @endif">
                Considering ({{$statusCount['considering']}})
            </a>
        </li>
        <li>
            <a
                href="{{ route('idea.index', ['status' => 'In Progress']) }}"
                wire:click.prevent="setStatus('In Progress')"
                class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'In Progress') border-blue text-gray-900 @endif">
                In Progress ({{$statusCount['in_progress']}})
            </a>
        </li>
    </ul>
    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li>
            <a
                href="{{ route('idea.index', ['status' => 'Implemented']) }}"
                wire:click.prevent="setStatus('Implemented')"
                class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'Implemented') border-blue text-gray-900 @endif">
                Implemented ({{$statusCount['implemented']}})
            </a>
        </li>
        <li>
            <a
                href="{{ route('idea.index', ['status' => 'Closed']) }}"
                wire:click.prevent="setStatus('Closed')"
                class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'Closed') border-blue text-gray-900 @endif">
                Closed ({{$statusCount['closed']}})
            </a>
        </li>
    </ul>
</nav>
