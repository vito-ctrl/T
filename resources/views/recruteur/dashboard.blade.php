<x-app-layout>
    <x-slot name="header">
        @php
            $u = Auth::user();
            $nom = $u->nom ?? '';
            $prenom = $u->prenom ?? '';
            $full = trim(($prenom ?: '') . ' ' . ($nom ?: ($u->name ?? 'Utilisateur')));
        @endphp

        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-white">Dashboard</h2>
                <p class="text-sm text-zinc-400">
                    Bienvenue, <span class="font-semibold text-white">{{ $full }}</span>.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/search') }}"
                   class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-black hover:bg-zinc-200 transition">
                    Rechercher des talents
                </a>
                <a href="{{ url('/profile/manage') }}"
                   class="rounded-xl border border-zinc-700 bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 transition">
                    Gérer mon profil
                </a>
            </div>
        </div>
    </x-slot>

    @php
        // stats statiques (tu brancheras DB plus tard)
        $stats = [
            ['label' => 'Profils consultés', 'value' => 12],
            ['label' => 'Demandes d'amitié', 'value' => 3],
            ['label' => 'Notifications', 'value' => 5],
            ['label' => 'Suggestions', 'value' => 8],
        ];

        $quickActions = [
            [
                'title' => 'Recherche',
                'desc' => 'Trouver un utilisateur par nom/prénom.',
                'href' => url('/search'),
                'btn' => 'Ouvrir',
            ],
            [
                'title' => 'Réseau (Amis)',
                'desc' => 'Gérer les demandes et la liste d'amis.',
                'href' => url('/relationships'),
                'btn' => 'Voir le réseau',
            ],
            [
                'title' => 'Notifications',
                'desc' => 'Voir les dernières activités et demandes.',
                'href' => url('/notifications'),
                'btn' => 'Voir',
            ],
            [
                'title' => 'Profil',
                'desc' => 'Modifier bio, photo (URL), nom/prénom.',
                'href' => url('/profile/manage'),
                'btn' => 'Modifier',
            ],
        ];

        $suggestions = [
            [
                'id' => 1,
                'nom' => 'El Fassi',
                'prenom' => 'Imane',
                'role' => 'RECHERCHEUR',
                'email' => 'imane@example.com',
                'biographie' => 'Laravel backend, APIs, PostgreSQL. Disponible.',
                'image' => 'https://i.pravatar.cc/200?img=32',
            ],
            [
                'id' => 2,
                'nom' => 'TechNova',
                'prenom' => 'SARL',
                'role' => 'RECRUTEUR',
                'email' => 'hr@technova.com',
                'biographie' => 'Entreprise SaaS RH. Recrute fullstack.',
                'image' => 'https://i.pravatar.cc/200?img=12',
            ],
        ];
    @endphp

    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($stats as $s)
                <div class="rounded-2xl bg-zinc-900 border border-zinc-800 shadow-xl shadow-black/20 p-5">
                    <div class="text-xs text-zinc-500">{{ $s['label'] }}</div>
                    <div class="mt-2 text-2xl font-semibold text-white">{{ $s['value'] }}</div>
                    <div class="mt-3 h-1.5 w-full rounded-full bg-zinc-800 overflow-hidden">
                        <div class="h-full w-2/3 rounded-full bg-white"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Quick actions -->
        <div class="grid gap-4 lg:grid-cols-2">
            <div class="rounded-2xl bg-zinc-900 border border-zinc-800 shadow-xl shadow-black/20 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-white">Actions rapides</h3>
                        <p class="mt-1 text-sm text-zinc-400">Accède vite aux pages principales.</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-zinc-800 grid place-items-center">
                        <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 6v12M6 12h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach($quickActions as $a)
                        <div class="rounded-2xl border border-zinc-800 bg-zinc-950 p-4 hover:bg-zinc-900 transition">
                            <div class="font-semibold text-white">{{ $a['title'] }}</div>
                            <div class="mt-1 text-sm text-zinc-400">{{ $a['desc'] }}</div>
                            <a href="{{ $a['href'] }}"
                               class="mt-4 inline-flex rounded-xl bg-white px-4 py-2 text-sm font-semibold text-black hover:bg-zinc-200 transition">
                                {{ $a['btn'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Profile card -->
            <div class="rounded-2xl bg-zinc-900 border border-zinc-800 shadow-xl shadow-black/20 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-white">Mon compte</h3>
                        <p class="mt-1 text-sm text-zinc-400">Infos de l'utilisateur connecté.</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-zinc-800 grid place-items-center">
                        <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M16 11a4 4 0 10-8 0 4 4 0 008 0z" stroke="currentColor" stroke-width="2"/>
                            <path d="M20 20a8 8 0 10-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 rounded-2xl border border-zinc-800 bg-zinc-950 p-5">
                    <div class="flex items-center gap-4">
                        <img src="{{$u?->image}}" class="h-14 w-14 rounded-2xl bg-zinc-800 grid place-items-center font-bold text-white object-cover"/>
                        <div class="min-w-0">
                            <div class="font-semibold text-white truncate">{{ $full }}</div>
                            <div class="text-sm text-zinc-400 truncate">{{ $u->email }}</div>
                            <div class="mt-2 inline-flex rounded-full bg-zinc-800 px-2.5 py-1 text-xs font-semibold text-white ring-1 ring-zinc-700">
                                {{ $u->role ?? 'RECHERCHEUR' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ url('/profile/manage') }}"
                           class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-black hover:bg-zinc-200 transition">
                            Modifier profil
                        </a>
                        <a href="{{ url('/notifications') }}"
                           class="rounded-xl border border-zinc-700 bg-zinc-900 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 transition">
                            Voir notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>