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
                    <span>Recruteur</span>
                    <span class="mx-2">/</span>
                    <span class="text-white">Détails offre</span>
                </nav>

                <h2 class="text-3xl font-black text-white tracking-tight">
                    {{ $offer->titre }}
                </h2>

                <p class="mt-1 text-sm text-zinc-400">
                    {{ $offer->type_contrat }} @if($offer->ville) • {{ $offer->ville }} @endif
                </p>
            </div>
            

            <div class="flex items-center gap-2">
                <a href="{{ route('offers.accepted', $offer->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-black text-sm font-black hover:bg-zinc-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Personnes acceptées
                </a>

                <a href="{{ route('offers.index') ?? url('/offers') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-zinc-900 border border-zinc-800 text-sm font-bold text-white shadow-xl shadow-black/20 hover:bg-zinc-800 transition-all">
                    <svg class="me-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-4 text-sm text-white">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Offer card -->
            <div class="rounded-[2rem] bg-zinc-900 border border-zinc-800 shadow-2xl shadow-black/40 overflow-hidden">
                <div class="grid lg:grid-cols-3">
                    <div class="lg:col-span-1">
                        <div class="h-56 lg:h-full w-full bg-zinc-950">
                            <img src="{{ $offer->image }}" alt="{{ $offer->titre }}"
                                 class="h-full w-full object-cover opacity-90">
                        </div>
                    </div>

                    <div class="lg:col-span-2 p-6 sm:p-8 space-y-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-zinc-800 px-3 py-1 text-xs font-black text-white">
                                {{ $offer->type_contrat }}
                            </span>

                            <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-xs font-black text-black ring-1 ring-zinc-700">
                                PUBLIÉE
                            </span>

                            <span class="text-xs text-zinc-500 font-semibold">
                                • {{ $offer->created_at?->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="prose prose-invert max-w-none">
                            <p class="text-zinc-300 leading-relaxed">
                                {{ $offer->description }}
                            </p>
                        </div>

                        <div class="pt-2 border-t border-zinc-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="text-sm text-zinc-400">
                                Recruteur :
                                <span class="font-bold text-white">
                                    {{ $offer->recruiter?->prenom }} {{ $offer->recruiter?->nom }}
                                </span>
                            </div>

                            <div class="text-sm font-bold text-zinc-300">
                                Candidatures :
                                <span class="text-white">{{ $offer->applications->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications list -->
            <div class="rounded-[2rem] bg-zinc-900 border border-zinc-800 shadow-2xl shadow-black/40 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-zinc-800">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-white">Candidatures</h3>
                        <span class="text-sm font-bold text-zinc-400">
                            {{ $offer->applications->count() }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-zinc-400">Liste des personnes qui ont postulé à cette offre.</p>
                </div>

                <div class="p-6 sm:p-8">
                    @if($offer->applications->count() === 0)
                        <div class="rounded-2xl bg-zinc-950 border border-zinc-800 p-6 text-zinc-400">
                            Aucune candidature pour le moment.
                        </div>
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($offer->applications as $app)
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
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>