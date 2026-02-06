<x-app-layout>
    <!-- Background glow -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-white/5 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[5%] w-[30%] h-[30%] rounded-full bg-white/5 blur-[100px]"></div>
    </div>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-zinc-600">
                    <span>Offres</span>
                    <span class="mx-2">/</span>
                    <span class="text-white">Candidats acceptés</span>
                </nav>

                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Acceptés — <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-zinc-400">
                        {{ $offer->titre }}
                    </span>
                </h2>

                <p class="mt-1 text-sm text-zinc-400">
                    Liste des candidats dont la candidature a été acceptée.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('offers.show', $offer->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-zinc-900 border border-zinc-800 text-sm font-black text-white hover:bg-zinc-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Retour détails
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="rounded-2xl bg-zinc-900/80 backdrop-blur border border-zinc-800 shadow-2xl shadow-black/40 overflow-hidden">
                <div class="px-6 py-5 border-b border-zinc-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center rounded-full bg-white px-2.5 py-1 text-[11px] font-black text-black ring-1 ring-zinc-700">
                            ACCEPTED
                        </span>
                        <p class="text-sm font-bold text-zinc-300">
                            {{ $offer->applications->count() }} candidat(s) accepté(s)
                        </p>
                    </div>

                    <a href="{{ route('offers.show', $offer->id) }}"
                       class="text-sm font-semibold text-white hover:text-zinc-300 transition">
                        Voir toutes les candidatures →
                    </a>
                </div>

                <div class="p-6">
                    @if($offer->applications->count() === 0)
                        <div class="rounded-2xl bg-zinc-950 border border-zinc-800 p-10 text-center">
                            <h3 class="text-lg font-black text-white">Aucun candidat accepté</h3>
                            <p class="mt-1 text-zinc-400">Accepte une candidature depuis la page détails de l'offre.</p>
                        </div>
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($offer->applications as $app)
                                @php $cand = $app->rechercheur; @endphp

                                @if($cand)
                                    <x-applicant-card
                                        :applicationId="$app->id"
                                        :status="$app->status"
                                        :href="route('users.show', $app->rechercheur->user_id)"
                                        :userId="$app->rechercheur->user_id"
                                        :nom="$app->rechercheur->user->nom"
                                        :prenom="$app->rechercheur->user->prenom"
                                        :role="$app->rechercheur->user->role"
                                        :email="$app->rechercheur->user->email"
                                        :biographie="$app->rechercheur->user->biographie"
                                        :image="$app->rechercheur->user->image"
                                        :appliedAt="$app->created_at"
                                    />
                                @else
                                    <div class="rounded-2xl bg-zinc-950 border border-zinc-800 p-5 text-sm text-zinc-400">
                                        Candidature invalide (candidat introuvable). ID candidature: {{ $app->id }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>