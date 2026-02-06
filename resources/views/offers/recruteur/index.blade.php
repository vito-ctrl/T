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
                    <span class="text-white">Offres</span>
                </nav>

                <h2 class="text-3xl font-black text-white tracking-tight">
                    Mes <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-zinc-400">offres</span>
                </h2>

                <p class="mt-1 text-sm text-zinc-400">
                    Créez et gérez vos offres d'emploi.
                </p>
            </div>


            <div x-data="{ open:false }" class="flex items-center gap-2">
                <button @click="open = true"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-black text-sm font-black hover:bg-zinc-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Créer une offre
                </button>

                <template x-teleport="body">
                    <div
                        x-cloak
                        x-show="open"
                        x-transition.opacity
                        @keydown.escape.window="open = false"
                        class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                    >
                        <!-- overlay -->
                        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="open=false"></div>

                        <!-- panel -->
                        <div
                            @click.stop
                            x-transition
                            class="relative z-10 w-full max-w-2xl rounded-[2rem] bg-zinc-900 shadow-2xl border border-zinc-800 overflow-hidden"
                        >
                            <div class="p-6 border-b border-zinc-800 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-black text-white">Nouvelle offre</h3>
                                    <p class="text-sm text-zinc-400">Remplis les champs obligatoires (*)</p>
                                </div>
                                <button @click="open=false" class="p-2 rounded-xl hover:bg-zinc-800 text-zinc-400 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <form method="POST" action="{{ route('offers.store') }}" class="p-6 space-y-4">
                                @csrf

                                @if ($errors->any())
                                    <div class="rounded-2xl border border-zinc-800 bg-zinc-950 p-4 text-sm text-zinc-400">
                                        <ul class="list-disc ms-5">
                                            @foreach ($errors->all() as $e)
                                                <li>{{ $e }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="text-sm font-bold text-white">Type contrat *</label>
                                        <select name="type_contrat"
                                                class="mt-1 w-full rounded-2xl border border-zinc-800 bg-zinc-950 text-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-white focus:border-white">
                                            <option value="CDI">CDI</option>
                                            <option value="CDD">CDD</option>
                                            <option value="Full-time">Full-time</option>
                                            <option value="Stage">Stage</option>
                                            <option value="Freelance">Freelance</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm font-bold text-white">Ville</label>
                                        <input name="ville" type="text" placeholder="Casablanca, Rabat…"
                                               class="mt-1 w-full rounded-2xl border border-zinc-800 bg-zinc-950 text-white placeholder-zinc-500 px-4 py-2.5 text-sm focus:ring-2 focus:ring-white focus:border-white"/>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-bold text-white">Titre *</label>
                                        <input name="titre" type="text" placeholder="Ex: Développeur Fullstack"
                                               class="mt-1 w-full rounded-2xl border border-zinc-800 bg-zinc-950 text-white placeholder-zinc-500 px-4 py-2.5 text-sm focus:ring-2 focus:ring-white focus:border-white"/>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-bold text-white">Description *</label>
                                        <textarea name="description" rows="5" placeholder="Détail du poste..."
                                                  class="mt-1 w-full rounded-2xl border border-zinc-800 bg-zinc-950 text-white placeholder-zinc-500 px-4 py-2.5 text-sm focus:ring-2 focus:ring-white focus:border-white"></textarea>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-bold text-white">Image (URL) *</label>
                                        <input name="image" type="url" placeholder="https://..."
                                               class="mt-1 w-full rounded-2xl border border-zinc-800 bg-zinc-950 text-white placeholder-zinc-500 px-4 py-2.5 text-sm focus:ring-2 focus:ring-white focus:border-white"/>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-2">
                                    <button type="button" @click="open=false"
                                            class="rounded-2xl border border-zinc-800 px-5 py-2.5 text-sm font-black text-white hover:bg-zinc-800 transition">
                                        Annuler
                                    </button>
                                    <button type="submit"
                                            class="rounded-2xl bg-white px-5 py-2.5 text-sm font-black text-black hover:bg-zinc-200 transition">
                                        Créer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
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

            <!-- Cards -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($offers as $offer)
                    <x-job-offer-card :offer="$offer" />
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 rounded-2xl bg-zinc-900 border border-zinc-800 p-10 text-center">
                        <h3 class="text-lg font-black text-white">Aucune offre</h3>
                        <p class="mt-1 text-zinc-400">Clique sur "Créer une offre".</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>