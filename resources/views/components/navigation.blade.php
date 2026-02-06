<!-- {{-- resources/views/components/top-navbar.blade.php --}} -->
@props([
    'active' => 'dashboard', 
    'user'   => auth()->user(),
])

<nav class="bg-black border-b border-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            {{-- Left side: logo + main nav --}}
            <div class="flex items-center space-x-8">
                {{-- Main nav links --}}
                    @if($user->role->value == "RECRUTEUR")
                        <x-nav.recruteur :active="$active ?? 'dashboard' "/>
                    @elseif($user->role->value === 'RECHERCHEUR')
                        <x-nav.rechercheur :active="$active ?? 'dashboard' "/>
                    @else
                        <x-nav.rechercheur :active="$active ?? 'dashboard' "/>
                    @endif


            {{-- Right side: search + bell + avatar --}}
            <div class="flex items-center space-x-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="rounded-full p-2 text-white hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Déconnexion</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                        </svg>
                    </button>
                </form>

                {{-- Avatar --}}
                <button
                    class="flex items-center rounded-full border-2 border-transparent focus:outline-none focus:border-indigo-500">
                    <img
                        class="h-9 w-9 rounded-full object-cover"
                        src="{{ $user?->image ?? 'https://i.pravatar.cc/150?img=3' }}"
                        alt="{{ $user?->name ?? 'User avatar' }}"
                    >
                </button>
            </div>
        </div>
    </div>
</nav>