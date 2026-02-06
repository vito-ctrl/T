@props(['offer'])

@php
    $title = $offer->titre;
    $desc  = \Illuminate\Support\Str::limit($offer->description, 120);
    $ville = $offer->ville ?: '—';
    $type  = $offer->type_contrat;
    $img   = $offer->image;
    $isClosed = (bool) $offer->is_closed;

    $company = optional($offer->recruteur)->entreprise ?? 'Entreprise';
    $created = optional($offer->created_at)->format('d/m/Y') ?? '';
@endphp

<article class="group relative overflow-hidden rounded-[2rem] bg-zinc-900 border border-zinc-800 p-3
               transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,0,0,0.4)]">

    <!-- Cover image -->
    <div class="relative h-36 w-full rounded-[1.5rem] overflow-hidden">
        <img src="{{ $img }}" alt="{{ $title }}" class="h-full w-full object-cover opacity-90">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

        <div class="absolute top-3 left-3 flex gap-2">
            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-white/80 backdrop-blur border border-white/40 text-black">
                {{ $type }}
            </span>

            @if($isClosed)
                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-zinc-800/90 text-zinc-400">
                    Clôturée
                </span>
            @else
                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-white/90 text-black">
                    Ouverte
                </span>
            @endif
        </div>
    </div>

    <!-- Body -->
    <div class="px-3 pt-4 pb-3">
        <div class="space-y-1">
            <h3 class="text-lg font-black text-white tracking-tight group-hover:text-zinc-300 transition-colors">
                {{ $title }}
            </h3>
            <div class="text-xs text-zinc-500 font-semibold">
                {{ $company }} • {{ $ville }} • {{ $created }}
            </div>
        </div>

        <p class="mt-3 text-sm text-zinc-400 leading-relaxed min-h-[3.5rem]">
            {{ $desc }}
        </p>

        <div class="mt-5 flex items-center gap-2">
            <!-- (optionnel) bouton détail si tu ajoutes offers.show plus tard -->
            <form method="GET" action="{{ route('offers.recruteur.show', $offer) }}">
                @csrf
                <button type="submit"
                        class="flex-1 rounded-2xl border border-zinc-800 px-4 py-2.5 text-sm font-black text-white hover:bg-zinc-800 transition">
                    Détails
                </button>
            </form>

            @if(!$isClosed)
                <form method="POST" action="{{ route('offers.close', $offer->id) }}">
                    @csrf
                    <button type="submit"
                            class="rounded-2xl bg-white px-4 py-2.5 text-sm font-black text-black hover:bg-zinc-200 transition">
                        Clôturer
                    </button>
                </form>
            @else
                <button disabled
                        class="rounded-2xl bg-zinc-800 px-4 py-2.5 text-sm font-black text-zinc-600 cursor-not-allowed">
                    Fermée
                </button>
            @endif
        </div>
    </div>

    <!-- Decorative glow -->
    <div class="pointer-events-none absolute -bottom-10 -right-10 h-32 w-32 rounded-full bg-white/10 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
</article>