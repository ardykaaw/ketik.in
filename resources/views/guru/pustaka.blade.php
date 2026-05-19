<x-guru-layout>
<div class="container-xl py-6">

    <div class="mb-5">
        <h1 class="display-6 fw-bold mb-1">Pustaka Guru</h1>
        <p class="text-secondary fs-4">Semua dokumen yang pernah kamu generate tersimpan di sini.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible mb-4" style="border-radius:12px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($contents->isEmpty())
        <div class="card border-0 shadow-sm text-center py-6" style="border-radius:20px;">
            <div class="card-body">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" stroke="#d1fae5" stroke-width="1.5" viewBox="0 0 24 24" class="mb-3"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                <h3 class="fw-bold text-secondary mb-2">Pustaka masih kosong</h3>
                <p class="text-secondary mb-4">Mulai generate dokumen dari fitur-fitur Mode Guru.</p>
                <a href="{{ route('guru.index') }}" class="btn text-white fw-semibold" style="background:linear-gradient(135deg,#10b981,#059669);border-radius:10px;">Mulai Generate</a>
            </div>
        </div>
    @else
        {{-- Filter Chips --}}
        <div class="d-flex gap-2 flex-wrap mb-4">
            <a href="{{ route('guru.pustaka') }}" class="badge {{ !request('type') ? 'text-white' : 'bg-light text-secondary' }} px-3 py-2 text-decoration-none fw-semibold" style="{{ !request('type') ? 'background:linear-gradient(135deg,#10b981,#059669);' : '' }}border-radius:99px;font-size:0.8rem;">
                Semua
            </a>
            @foreach($typeLabels as $key => $label)
                <a href="{{ route('guru.pustaka', ['type' => $key]) }}" class="badge {{ request('type') === $key ? 'text-white' : 'bg-light text-secondary' }} px-3 py-2 text-decoration-none fw-semibold" style="{{ request('type') === $key ? 'background:linear-gradient(135deg,#10b981,#059669);' : '' }}border-radius:99px;font-size:0.8rem;">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="row g-3">
            @foreach($contents as $item)
                @php
                    $typeColors = [
                        'guru-soal'  => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fcd34d'],
                        'guru-modul' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'border' => '#93c5fd'],
                        'guru-rpp'   => ['bg' => '#ede9fe', 'text' => '#5b21b6', 'border' => '#c4b5fd'],
                        'guru-rekap' => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#6ee7b7'],
                    ];
                    $colors = $typeColors[$item->type] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'border' => '#e5e7eb'];
                @endphp
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:16px;border-top:3px solid {{ $colors['border'] }} !important;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
                                <span class="badge fw-semibold" style="background:{{ $colors['bg'] }};color:{{ $colors['text'] }};border-radius:8px;font-size:0.75rem;padding:4px 10px;">
                                    {{ $typeLabels[$item->type] ?? $item->type }}
                                </span>
                                <span class="text-secondary" style="font-size:0.75rem;white-space:nowrap;">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <h6 class="fw-bold mb-2 lh-sm" style="font-size:0.95rem;">{{ Str::limit($item->title, 70) }}</h6>
                            <p class="text-secondary mb-0" style="font-size:0.82rem;">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0 d-flex gap-2">
                            <a href="{{ route('guru.pustaka.show', $item->id) }}" class="btn btn-sm fw-semibold flex-grow-1" style="border-radius:8px;background:#f0fdf4;color:#059669;border:1px solid #d1fae5;">
                                Buka
                            </a>
                            <form method="POST" action="{{ route('guru.pustaka.destroy', $item->id) }}" onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($contents->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $contents->links() }}
            </div>
        @endif
    @endif

</div>
</x-guru-layout>
