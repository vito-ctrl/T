@props([
    'href' => '#',
    'userId' => null,

    'nom' => 'Nom',
    'prenom' => 'Prénom',
    'role' => 'RECHERCHEUR',
    'email' => 'email@exemple.com',
    'biographie' => 'Aucun bioghraphie pour le moment',
    'image' => null,

    'dejaAmi' => false,
    'isSender' => false,
])

@php
    $full = trim($prenom.' '.$nom);

    $roleValue = is_object($role)
        ? ($role->value ?? $role->name ?? 'RECHERCHEUR')
        : ($role ?? 'RECHERCHEUR');

    $roleValue = strtoupper((string) $roleValue);
    $roleLabel = $roleValue === 'RECRUTEUR' ? 'Recruteur' : 'Chercheur';

    $theme = $roleValue === 'RECRUTEUR'
        ? [
            'main' => 'zinc',
            'grad' => 'from-zinc-700 to-zinc-900',
            'soft' => 'bg-zinc-800 text-zinc-300 ring-zinc-700',
            'glow' => 'bg-white/10',
            'btn'  => 'bg-white hover:bg-zinc-200 text-black shadow-black/20',
            'ok'   => 'bg-white hover:bg-zinc-200 text-black shadow-black/20',
            'no'   => 'bg-zinc-800 hover:bg-zinc-700 text-white shadow-black/20',
          ]
        : [
            'main' => 'zinc',
            'grad' => 'from-zinc-700 to-zinc-900',
            'soft' => 'bg-zinc-800 text-zinc-300 ring-zinc-700',
            'glow' => 'bg-white/10',
            'btn'  => 'bg-white hover:bg-zinc-200 text-black shadow-black/20',
            'ok'   => 'bg-white hover:bg-zinc-200 text-black shadow-black/20',
            'no'   => 'bg-zinc-800 hover:bg-zinc-700 text-white shadow-black/20',
          ];

    $initials = mb_strtoupper(mb_substr($prenom ?: 'U', 0, 1) . mb_substr($nom ?: 'U', 0, 1));
    $shortBio = \Illuminate\Support\Str::limit($biographie ?? 'Aucune biographie disponible pour le moment.', 90);

    $acceptUrl = \Illuminate\Support\Facades\Route::has('relationships.accept') ? route('relationships.accept') : '#';
    $refuseUrl = \Illuminate\Support\Facades\Route::has('relationships.refuse') ? route('relationships.refuse') : '#';
@endphp

<article class="group relative max-w-sm w-full bg-zinc-900 rounded-[2rem] border border-zinc-800 p-3 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.4)] hover:-translate-y-2">
    <div class="absolute inset-0 transition-opacity opacity-0 group-hover:opacity-100 duration-500">
        <div class="absolute -top-10 -left-10 w-32 h-32 {{ $theme['glow'] }} blur-3xl rounded-full"></div>
    </div>

    <div class="relative h-32 w-full rounded-[1.5rem] overflow-hidden bg-gradient-to-br {{ $theme['grad'] }}">
        <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
        </svg>

        <div class="absolute top-3 right-3 flex items-center gap-2">
            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">
                {{ $roleLabel }}
            </span>

            @if($dejaAmi)
                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md text-white rounded-full border border-white/20">
                    Ami
                </span>
            @else
                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider bg-zinc-700/50 backdrop-blur-md text-white rounded-full border border-white/20">
                    Invitation
                </span>
            @endif
        </div>
    </div>

    <div class="relative px-4 pb-4">
        <div class="relative -mt-12 mb-3">
            <div class="relative inline-block">
                <div class="h-24 w-24 rounded-3xl bg-zinc-900 p-1.5 shadow-2xl shadow-black/40 transition-transform duration-500 group-hover:rotate-3">
                    <div class="h-full w-full rounded-2xl overflow-hidden bg-zinc-800 border border-zinc-700">
                        @if($image)
                            <img src="{{ $image }}" alt="{{ $full }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-900 text-2xl font-black text-zinc-500">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="absolute bottom-1 right-1 h-5 w-5 rounded-full bg-white border-4 border-zinc-900 shadow-sm"></div>
            </div>
        </div>

        <div class="space-y-1">
            <h3 class="text-xl font-black text-white tracking-tight group-hover:text-zinc-200 transition-colors">
                {{ $full }}
            </h3>
            <div class="flex items-center gap-1.5 text-zinc-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs font-medium">{{ $email }}</span>
            </div>
        </div>

        <p class="mt-4 text-sm text-zinc-400 leading-relaxed min-h-[3rem]">
            {{ $shortBio }}
        </p>

        <div class="mt-6 space-y-3">
            <a href="{{ $href }}"
               class="w-full inline-flex justify-center items-center py-3 px-4 rounded-2xl {{ $theme['btn'] }} text-sm font-bold shadow-lg transition-all active:scale-95">
                Afficher détails
            </a>

            @if($dejaAmi)
                <button type="button" disabled
                        class="w-full inline-flex justify-center items-center py-3 px-4 rounded-2xl border border-zinc-800 bg-zinc-950 text-zinc-600 text-sm font-bold cursor-not-allowed">
                    Déjà ami
                </button>
            @else
                @if(!$isSender)
                    <div class="grid grid-cols-2 gap-3">
                        <form method="POST" action="{{ $acceptUrl }}">
                            @csrf
                            <input type="hidden" name="sender_id" value="{{ $userId }}">
                            <input type="hidden" name="reciever_id" value="{{ auth()->id() }}">
                            <button type="submit"
                                    class="w-full inline-flex justify-center items-center py-3 px-4 rounded-2xl {{ $theme['ok'] }} text-sm font-bold shadow-lg transition-all active:scale-95">
                                Accepter
                            </button>
                        </form>

                        <form method="POST" action="{{ $refuseUrl }}">
                            @csrf
                            <input type="hidden" name="sender_id" value="{{ $userId }}">
                            <input type="hidden" name="reciever_id" value="{{ auth()->id() }}">
                            <button type="submit"
                                    class="w-full inline-flex justify-center items-center py-3 px-4 rounded-2xl {{ $theme['no'] }} text-sm font-bold shadow-lg transition-all active:scale-95">
                                Refuser
                            </button>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-zinc-950 rounded-full -z-10 group-hover:bg-zinc-800 transition-colors"></div>
</article>