@extends('layouts.dashboard')

@section('content')
<div class="container-xl mt-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm" style="border-radius: 16px;">
                <div class="card-body py-5">
                    <div class="spinner-border text-primary mb-4" role="status" style="width: 4rem; height: 4rem;"></div>
                    <h2 class="fw-bold mb-3">{{ $title ?? 'Memproses Permintaan AI...' }}</h2>
                    <p class="text-muted" id="status-text">Sistem AI kami sedang menyusun konten terbaik untuk Anda. Silakan tunggu beberapa saat, halaman ini akan otomatis memuat hasilnya.</p>
                    
                    <div class="progress mt-4 mb-3" style="height: 10px; border-radius: 10px;">
                        <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted" id="time-elapsed">Waktu berlalu: 0 detik</small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const queueId = '{{ $queueId }}';
        const progressBar = document.getElementById('progress-bar');
        const timeElapsed = document.getElementById('time-elapsed');
        const statusText = document.getElementById('status-text');
        
        let seconds = 0;
        let progress = 10;
        
        const timer = setInterval(() => {
            seconds++;
            timeElapsed.textContent = `Waktu berlalu: ${seconds} detik`;
            
            // Fake progress animation
            if (progress < 90) {
                progress += (Math.random() * 5);
                progressBar.style.width = `${progress}%`;
            }
        }, 1000);

        const checkStatus = async () => {
            try {
                const response = await fetch(`/api/queue/${queueId}`);
                const data = await response.json();

                if (data.status === 'completed') {
                    clearInterval(timer);
                    progressBar.style.width = '100%';
                    progressBar.classList.remove('progress-bar-animated');
                    progressBar.classList.add('bg-success');
                    statusText.innerHTML = '<span class="text-success fw-bold">Selesai! Mengalihkan ke hasil...</span>';
                    
                    setTimeout(() => {
                        window.location.href = `/library/${data.content_id}`;
                    }, 1000);
                } else if (data.status === 'failed') {
                    clearInterval(timer);
                    progressBar.style.width = '100%';
                    progressBar.classList.remove('progress-bar-animated', 'bg-primary');
                    progressBar.classList.add('bg-danger');
                    statusText.innerHTML = `<span class="text-danger fw-bold">Gagal: ${data.message}</span>`;
                    
                    Swal.fire('Oops!', `Terjadi kesalahan: ${data.message}`, 'error').then(() => {
                        window.history.back();
                    });
                } else {
                    // pending or processing, keep checking
                    setTimeout(checkStatus, 3000);
                }
            } catch (error) {
                console.error('Error checking status:', error);
                setTimeout(checkStatus, 5000);
            }
        };

        // Start polling after 2 seconds
        setTimeout(checkStatus, 2000);
    });
</script>
@endpush
@endsection
