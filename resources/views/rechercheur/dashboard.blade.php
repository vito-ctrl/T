<x-app-layout>
    @php
        $u = Auth::user();
        $nom = $u->nom ?? '';
        $prenom = $u->prenom ?? '';
        $full = trim(($prenom ?: '') . ' ' . ($nom ?: ($u->name ?? 'Utilisateur')));
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-white">Dashboard</h2>

                <p class="text-sm text-gray-400">
                    Bienvenue,
                    <span class="font-semibold text-gray-200">{{ $full }}</span>.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/search') }}"
                   class="rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:from-purple-700 hover:to-blue-700 transition shadow-lg shadow-purple-500/30">
                    Rechercher des talents
                </a>

                <a href="{{ url('/profile/manage') }}"
                   class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition">
                    Gérer mon profil
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $stats = [
            ['label' => 'Profils consultés', 'value' => 12, 'color' => 'from-purple-500 to-purple-600'],
['label' => "Demandes d'amitié", 'value' => 3, 'color' => 'from-blue-500 to-blue-600'],
            ['label' => 'Notifications', 'value' => 5, 'color' => 'from-emerald-500 to-emerald-600'],
            ['label' => 'Suggestions', 'value' => 8, 'color' => 'from-orange-500 to-orange-600'],
        ];

        $quickActions = [
            [
                'title' => 'Recherche',
                'desc' => 'Trouver un utilisateur par nom/prénom.',
                'href' => url('/search'),
                'btn' => 'Ouvrir',
                'icon' => '🔍',
            ],
            [
                'title' => 'Réseau (Amis)',
                'desc' => 'Gérer les demandes et la liste d\'amis.',
                'href' => url('/relationships'),
                'btn' => 'Voir le réseau',
                'icon' => '👥',
            ],


            [
                'title' => 'Notifications',
                'desc' => 'Voir les dernières activités et demandes.',
                'href' => url('/notifications'),
                'btn' => 'Voir',
                'icon' => '🔔',
            ],
            [
                'title' => 'Profil',
                'desc' => 'Modifier bio, photo (URL), nom prénom.',
                'href' => url('/profile/manage'),
                'btn' => 'Modifier',
                'icon' => '⚙️',
            ],
        ];
    @endphp

    <div class="space-y-6">

        <!-- STATS -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($stats as $s)
                <div class="rounded-2xl bg-gray-800/50 backdrop-blur-sm border border-gray-700 shadow-lg p-5 hover:bg-gray-800 transition-all hover:scale-105 group">
                    <div class="text-xs font-medium text-gray-400 uppercase tracking-wider">
                        {{ $s['label'] }}
                    </div>

                    <div class="mt-2 text-3xl font-bold text-white">
                        {{ $s['value'] }}
                    </div>

                    <div class="mt-4 h-2 w-full rounded-full bg-gray-700 overflow-hidden">
                        <div class="h-full w-2/3 rounded-full bg-gradient-to-r {{ $s['color'] }} transition-all group-hover:w-3/4"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 lg:grid-cols-2">

            <!-- ACTIONS RAPIDES -->
            <div class="rounded-2xl bg-gray-800/50 backdrop-blur-sm border border-gray-700 shadow-lg p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-white">
                            Actions rapides
                        </h3>

                        <p class="mt-1 text-sm text-gray-400">
                            Accède vite aux pages principales.
                        </p>
                    </div>

                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-purple-600 to-blue-600 grid place-items-center border border-purple-500/50 shadow-lg shadow-purple-500/30">
                        <span class="font-bold text-white">⚡</span>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach($quickActions as $a)
                        <div class="rounded-2xl border border-gray-700 bg-gray-900/50 p-4 hover:bg-gray-700/50 hover:border-gray-600 transition-all group">

                            <div class="flex items-center gap-2">
                                <span class="text-xl">{{ $a['icon'] }}</span>
                                <div class="font-semibold text-white">
                                    {{ $a['title'] }}
                                </div>
                            </div>

                            <div class="mt-2 text-sm text-gray-400">
                                {{ $a['desc'] }}
                            </div>

                            <a href="{{ $a['href'] }}"
                               class="mt-4 inline-flex rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 px-4 py-2 text-sm font-semibold text-white hover:from-purple-700 hover:to-blue-700 transition shadow-md group-hover:shadow-lg group-hover:shadow-purple-500/30">
                                {{ $a['btn'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- PROFILE -->
            <div class="rounded-2xl bg-gray-800/50 backdrop-blur-sm border border-gray-700 shadow-lg p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-white">
                            Mon compte
                        </h3>

                        <p class="mt-1 text-sm text-gray-400">
                            Infos de l'utilisateur connecté.
                        </p>
                    </div>

                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-600 grid place-items-center border border-emerald-500/50 shadow-lg shadow-emerald-500/30">
                        <span class="text-white font-bold">👤</span>
                    </div>
                </div>

                <div class="mt-5 rounded-2xl border border-gray-700 bg-gradient-to-br from-gray-900/80 to-gray-800/80 p-5">
                    <div class="flex items-center gap-4">

                        <div class="relative">
                            <img src="{{ $u?->image }}"
                                 class="h-16 w-16 rounded-2xl bg-gray-700 border-2 border-purple-500 shadow-lg shadow-purple-500/30"/>
                            <div class="absolute -bottom-1 -right-1 h-5 w-5 rounded-full bg-emerald-500 border-2 border-gray-900"></div>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate text-lg">
                                {{ $full }}
                            </div>

                            <div class="text-sm text-gray-400 truncate">
                                {{ $u->email }}
                            </div>

                            <div class="mt-2 inline-flex rounded-full bg-gradient-to-r from-purple-600/20 to-blue-600/20 px-3 py-1 text-xs font-semibold text-purple-300 border border-purple-500/30">
                                {{ $u->role ?? 'RECHERCHEUR' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ url('/profile/manage') }}"
                           class="rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 px-4 py-2 text-sm font-semibold text-white hover:from-purple-700 hover:to-blue-700 transition shadow-md hover:shadow-lg hover:shadow-purple-500/30">
                            Modifier profil
                        </a>

                        <a href="{{ url('/notifications') }}"
                           class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 transition">
                            Voir notifications
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>