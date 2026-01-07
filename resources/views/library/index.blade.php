<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h1 class="display-5 fw-bold mb-1">Pustaka Saya</h1>
                <p class="text-secondary fs-3">Kumpulan karya yang telah Anda buat bersama AI.</p>
            </div>
            <div>
                <div class="input-icon">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                    </span>
                    <input type="text" value="" class="form-control" placeholder="Cari karya..." style="border-radius: 10px; min-width: 250px;">
                </div>
            </div>
        </div>

        @if($contents->isEmpty())
            <div class="card border-0 shadow-sm py-8" style="border-radius: 20px;">
                <div class="card-body text-center">
                    <div class="avatar bg-primary-lt mb-4" style="width: 80px; height: 80px; border-radius: 20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                    </div>
                    <h2 class="fw-bold mb-2">Pustaka Masih Kosong</h2>
                    <p class="text-muted fs-3 mb-4">Mulailah menulis dengan AI untuk mengisi pustaka pribadi Anda.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2 fw-bold" style="border-radius: 10px;">Mulai Menulis</a>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($contents as $content)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm content-card" style="border-radius: 16px; transition: transform 0.2s;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary-lt px-2 py-1 text-uppercase fw-bold small" style="border-radius: 6px;">{{ $content->type }}</span>
                                    <span class="ms-auto text-muted small">{{ $content->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="fw-bold mb-2 text-truncate">{{ $content->title }}</h3>
                                <p class="text-secondary small mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($content->content), 120) }}
                                </p>
                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('library.show', $content) }}" class="btn btn-light flex-fill fw-bold" style="border-radius: 8px;">Buka</a>
                                    <form action="{{ route('library.destroy', $content) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karya ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light-danger btn-icon" style="border-radius: 8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $contents->links() }}
            </div>
        @endif
    </div>

    <style>
        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-dashboard-layout>
