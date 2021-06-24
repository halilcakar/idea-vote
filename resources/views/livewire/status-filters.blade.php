<nav class="hidden md:flex items-center justify-between text-gray-400 text-xs">
    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li>
            <a href="#" wire:click.prevent="setStatus('All')" class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'All') border-blue text-gray-900 @endif">All Ideas (87)</a>
        </li>
        <li>
            <a href="#" wire:click.prevent="setStatus('Considering')" class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'Considering') border-blue text-gray-900 @endif">Considering (6)</a>
        </li>
        <li>
            <a href="#" wire:click.prevent="setStatus('In Progress')" class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'In Progress') border-blue text-gray-900 @endif">In Progress (1)</a>
        </li>
    </ul>
    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li>
            <a href="#" wire:click.prevent="setStatus('Implemented')" class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'Implemented') border-blue text-gray-900 @endif">Implemented (10)</a>
        </li>
        <li>
            <a href="#" wire:click.prevent="setStatus('Closed')" class="transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if($status === 'Closed') border-blue text-gray-900 @endif">Closed (55)</a>
        </li>
    </ul>
</nav>
