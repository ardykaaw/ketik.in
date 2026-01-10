<x-dashboard-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex align-items-center mb-5">
                    <a href="{{ route('library.index') }}" class="btn btn-icon btn-light me-3" style="border-radius: 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    </a>
                    <div>
                        <span class="badge bg-primary-lt mb-1">{{ strtoupper($content->type) }}</span>
                        <h1 class="display-6 fw-bold m-0">{{ $content->title }}</h1>
                    </div>
                    <div class="ms-auto d-flex gap-2">
                        <button class="btn btn-outline-primary fw-bold" style="border-radius: 10px;" onclick="copyToClipboard()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                            Salin Teks
                        </button>
                        <a href="{{ route('library.export', $content) }}" class="btn btn-primary fw-bold" style="border-radius: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                            Export PDF
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4 paper-card">
                    <div class="card-body p-5">
                        <div id="generated-content" class="prose max-w-none">{{ $content->content }}</div>
                    </div>
                    <div class="card-footer bg-light border-0 p-4" style="border-bottom-left-radius: 24px; border-bottom-right-radius: 24px;">
                        <div class="row align-items-center">
                            <div class="col text-muted small">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 15" /></svg>
                                Dibuat pada {{ $content->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-green-lt">AI Optimized</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refinement Card -->
                <div class="card border-1 border-primary shadow-sm mb-4" style="border-radius: 20px; border-style: dashed !important; background: #fdfdff;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 11V7l5-5 5 5v4"></path><path d="M12 2v20"></path><path d="M7 13v4l5 5 5-5v-4"></path></svg>
                            Belum puas? Revisi dengan AI
                        </h4>
                        <p class="text-muted small mb-4">Berikan perintah tambahan untuk memperbaiki teks di atas. Misal: "Buat lebih formal", "Tambahkan 1 paragraf lagi tentang kesimpulan", atau "Ubah nada menjadi lebih ceria".</p>
                        
                        <form action="{{ route('library.refine', $content) }}" method="POST" onsubmit="refineBtn.disabled = true; refineLoader.classList.remove('d-none'); refineText.classList.add('d-none');">
                            @csrf
                            <div class="input-group">
                                <textarea name="instruction" class="form-control border-2" rows="2" placeholder="Tulis instruksi revisi..." style="border-radius: 12px 0 0 12px;" required></textarea>
                                <button type="submit" class="btn btn-primary px-4" id="refineBtn" style="border-radius: 0 12px 12px 0;">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="refineLoader"></span>
                                    <span id="refineText">Kirim Perintah</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Prompt Visibility Section -->
                @if($content->prompt)
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-header bg-transparent border-0 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#promptCollapse" aria-expanded="false" aria-controls="promptCollapse">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="fw-bold mb-0 text-muted d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><line x1="3" y1="6" x2="3" y2="19" /><line x1="12" y1="6" x2="12" y2="19" /><line x1="21" y1="6" x2="21" y2="19" /></svg>
                                Lihat Prompt / Instruksi Awal
                            </h4>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="6 9 12 15 18 9" /></svg>
                        </div>
                    </div>
                    <div class="collapse" id="promptCollapse">
                        <div class="card-body pt-0 text-muted" style="white-space: pre-wrap;">{{ $content->prompt }}</div>
                    </div>
                </div>
                @endif

                <!-- Supporting Documents Section (Bukti Dukung) - Per Action Item -->
                @if($content->type === 'e-kinerja')
                <div class="card border-0 shadow-sm mt-4" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-success me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 17h6" /><path d="M9 13h6" /></svg>
                            Bukti Dukung Rencana Aksi
                        </h4>
                        <p class="text-muted small mb-4">Upload bukti dukung untuk setiap rencana aksi dengan mengklik tombol di samping item.</p>

                        <div class="alert alert-info" style="border-radius: 12px;">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M12 8l.01 0" /><path d="M11 12l1 0l0 4l1 0" /></svg>
                                <div>Tombol upload akan muncul saat Anda mengarahkan kursor ke setiap item rencana aksi di atas.</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Upload Bukti Dukung -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Upload Bukti Dukung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="uploadForm" action="{{ route('library.attachment.upload', $content) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="action_item_index" id="actionItemIndex">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rencana Aksi</label>
                            <div id="actionItemPreview" class="p-3 bg-light rounded" style="border-radius: 10px;"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih File</label>
                            <input type="file" name="file" class="form-control border-2" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx" style="border-radius: 10px;">
                            <div class="form-hint mt-2">Maksimal 10MB. Format: PDF, DOC, DOCX, JPG, PNG, XLS, XLSX</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        // Attachments data from server
        const attachmentsData = @json($content->attachments);
        
        document.addEventListener('DOMContentLoaded', function() {
            const contentDiv = document.getElementById('generated-content');
            const rawContent = contentDiv.innerText;
            
            // Parse Markdown
            contentDiv.innerHTML = marked.parse(rawContent);

            // Add upload buttons and attachments to list items
            const listItems = contentDiv.querySelectorAll('li');
            listItems.forEach((li, index) => {
                // IMPORTANT: Use innerHTML to preserve Bold/Italic/Links from AI
                const originalHtml = li.innerHTML;
                
                // Get attachments for this action item
                const itemAttachments = attachmentsData.filter(att => att.action_item_index === index);
                
                // Build attachments HTML
                let attachmentsHtml = '';
                if (itemAttachments.length > 0) {
                    attachmentsHtml = '<div class="mt-2 text-start"><small class="text-muted fw-bold">Bukti Dukung:</small><div class="d-flex flex-wrap gap-2 mt-1">';
                    itemAttachments.forEach(att => {
                        attachmentsHtml += `
                            <div class="badge bg-success-lt d-flex align-items-center gap-1 py-2 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paperclip" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" /></svg>
                                <a href="/storage/${att.file_path}" target="_blank" class="text-success text-decoration-none" download>${att.original_name}</a>
                                <form action="/attachment/${att.id}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus file ini?')">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}'}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent text-danger" style="line-height: 1;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                    </button>
                                </form>
                            </div>
                        `;
                    });
                    attachmentsHtml += '</div></div>';
                }
                
                li.innerHTML = `
                    <div class="d-flex align-items-start justify-content-between group-hover-action">
                        <div class="flex-grow-1 list-content">
                            ${originalHtml}
                            ${attachmentsHtml}
                        </div>
                        <div class="actions ms-2 d-flex gap-1" style="opacity: 0; transition: opacity 0.2s;">
                            <button onclick="openUploadModal(${index}, this)" class="btn btn-sm btn-ghost-success p-1 border-0" title="Upload Bukti Dukung">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paperclip" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" /></svg>
                            </button>
                            <button onclick="editItem(this)" class="btn btn-sm btn-ghost-primary p-1 border-0" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                            </button>
                            <button onclick="removeItem(this)" class="btn btn-sm btn-ghost-danger p-1 border-0" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            </button>
                        </div>
                    </div>
                `;
                
                li.addEventListener('mouseenter', () => {
                    li.querySelector('.actions').style.opacity = '1';
                });
                li.addEventListener('mouseleave', () => {
                    li.querySelector('.actions').style.opacity = '0';
                });
            });
        });

        function openUploadModal(index, btn) {
            // Get text from the list item, stripping HTML tags for the preview
            const liContent = btn.closest('.group-hover-action').querySelector('.list-content').innerText;
            const previewText = liContent.substring(0, 100) + (liContent.length > 100 ? '...' : ''); // Truncate

            document.getElementById('actionItemIndex').value = index;
            document.getElementById('actionItemPreview').innerHTML = `<strong>Item #${index + 1}:</strong> ${previewText}`;
            const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
            modal.show();
        }

        async function editItem(btn) {
            // Edit HTML content
            const contentContainer = btn.closest('.group-hover-action').querySelector('.list-content');
            
            // Remove the attachment div temporarily to get just the text content for editing
            const attachmentsDiv = contentContainer.querySelector('.mt-2.text-start'); 
            const attachmentsHtmlStore = attachmentsDiv ? attachmentsDiv.outerHTML : '';
            if(attachmentsDiv) attachmentsDiv.remove();

            const currentHtml = contentContainer.innerHTML;

            const { value: newHtml } = await Swal.fire({
                title: 'Edit Rencana Aksi',
                html: '<div id="quill-editor" style="height: 200px;">' + currentHtml + '</div>',
                showCancelButton: true,
                confirmButtonText: 'Simpan Perubahan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2fb344',
                width: '600px',
                didOpen: () => {
                    window.quill = new Quill('#quill-editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['clean']
                            ]
                        }
                    });
                },
                preConfirm: () => {
                    return window.quill.root.innerHTML;
                }
            });

            if (newHtml) {
                // 1. Update DOM immediately for feedback
                contentContainer.innerHTML = newHtml + attachmentsHtmlStore;

                // 2. Prepare content for saving (Strip UI elements)
                const fullContentDiv = document.getElementById('generated-content').cloneNode(true);
                
                // Remove all Action Buttons (.actions)
                fullContentDiv.querySelectorAll('.actions').forEach(el => el.remove());
                
                // Remove all Attachment previews (.mt-2.text-start) - we only want the text/structure
                fullContentDiv.querySelectorAll('.mt-2.text-start').forEach(el => el.remove());
                
                // Remove wrapper divs if we want raw list? 
                // No, the list structure <div class="d-flex ..."> is generated by JS in show.blade.php from Markdown.
                // IF we save HTML, we save the DIVs. 
                // Problem: Next load, marked.parse will see DIVs and not touch them? Or maybe it will.
                // Better approach: We are saving the *rendered HTML* now.
                // The Controller saves it.
                // Next reload: line 135 `contentDiv.innerHTML = marked.parse(rawContent)`
                // If rawContent is HTML, marked basically returns it as is (if configured, or strict).
                // But wait, line 138 `listItems.forEach` adds the buttons AGAIN.
                // So if we save the DIVs (.group-hover-action), we get nested structure?
                // Address this by Stripping the `.group-hover-action` wrapper and keeping just `li` content?
                // Actually, `li` contains `.group-hover-action`.
                // If we save the HTML of `ul > li`, the `li` has the wrapper.
                // Next load: JS finds `li`. It appends `.actions` again?
                // Line 168: `li.innerHTML = ...` REPLACES content.
                // So if we save the wrapper, the JS will WRAP the wrapper. Double wrapper!
                
                // FIX: We must UNWRAP the content before saving.
                // We want to save what the AI gave us (roughly).
                // Iterate clean clone list items and unwrap their content.
                fullContentDiv.querySelectorAll('li').forEach(li => {
                   const listContent = li.querySelector('.list-content');
                   if (listContent) {
                       // Keep only the HTML inside list-content (minus attachments which we removed above)
                       li.innerHTML = listContent.innerHTML;
                   }
                });

                const finalContent = fullContentDiv.innerHTML;

                // 3. Send to Server
                try {
                    const response = await fetch('{{ route('library.update', $content) }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ content: finalContent })
                    });
                    
                    if (!response.ok) throw new Error('Gagal menyimpan ke server');

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil diperbarui & Disimpan'
                    });

                } catch (error) {
                    Swal.fire('Error', 'Gagal menyimpan perubahan: ' + error.message, 'error');
                }

            } else {
                // Restore if cancelled
                contentContainer.innerHTML = currentHtml + attachmentsHtmlStore;
            }
        }

        async function removeItem(btn) {
            const result = await Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Item rencana aksi ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7174',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                btn.closest('li').remove();
                Swal.fire({
                    title: 'Terhapus!',
                    text: 'Item berhasil dihapus.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        }

        function copyToClipboard() {
            const content = document.getElementById('generated-content').innerText;
            navigator.clipboard.writeText(content).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Teks berhasil disalin!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
            });
        }
    </script>
    <style>
        /* Light Mode (Default) */
        .paper-card {
            border-radius: 24px;
            background: #fff url('https://www.transparenttextures.com/patterns/clean-gray-paper.png');
            transition: background-color 0.3s, color 0.3s;
        }
        .prose {
            font-size: 1.1rem;
            line-height: 1.6; /* Reduced from 1.8 */
            color: #334155;
            white-space: pre-wrap;
        }
        .prose h1, .prose h2, .prose h3 {
            margin-top: 1.5rem; /* Reduced from 2rem */
            margin-bottom: 0.75rem; /* Reduced from 1rem */
            font-weight: 700;
            color: #1e293b;
        }
        .prose p {
            margin-bottom: 0.85rem; /* Reduced from 1.25rem */
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem; /* Slightly more space between items */
            position: relative;
        }
        /* FIX: Remove margins from paragraphs inside lists to align text with numbers */
        /* Target the new .list-content wrapper's first child */
        .prose li .list-content > :first-child {
            margin-top: 0 !important;
            margin-bottom: 0.25rem !important;
        }
        /* Keep spacing for subsequent paragraphs */
        .prose li .list-content p + p {
            margin-top: 0.5rem !important;
        }
        .prose blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1rem;
            margin: 1.25rem 0;
            font-style: italic;
            color: #475569;
        }
        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            border: 1px solid #e2e8f0;
            background: white;
            font-size: 0.95rem;
        }

        /* Dark Mode Overrides */
        [data-theme="dark"] .paper-card {
            background-color: #1e293b !important; /* Slate-800 */
            background-image: none !important; /* Force kill texture */
            border: 1px solid #334155;
            color: #f8fafc !important;
        }
        [data-theme="dark"] .prose {
            color: #f8fafc !important; /* Force White */
        }
        /* Wildcard Safety Net for ANY text inside prose in dark mode */
        [data-theme="dark"] .prose * {
            color: inherit !important; /* Inherit from .prose */
        }
        [data-theme="dark"] .prose h1, 
        [data-theme="dark"] .prose h2, 
        [data-theme="dark"] .prose h3,
        [data-theme="dark"] .prose strong,
        [data-theme="dark"] .prose b {
            color: #ffffff !important; /* Pure White */
        }
        [data-theme="dark"] .prose p,
        [data-theme="dark"] .prose li,
        [data-theme="dark"] .prose ul,
        [data-theme="dark"] .prose ol {
            color: #e2e8f0 !important; /* Slate-200 */
        }
        [data-theme="dark"] .prose blockquote {
            color: #cbd5e1 !important; /* Slate-300 */
            border-left-color: #60a5fa !important;
        }
        [data-theme="dark"] .prose table {
            background: #0f172a !important; /* Slate-900 */
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        [data-theme="dark"] .prose th {
            background-color: #1e293b !important;
            border-bottom-color: #334155 !important;
            color: #ffffff !important;
        }
        [data-theme="dark"] .prose td {
            border-bottom-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .prose a {
            color: #60a5fa !important; /* Light Blue for Links */
            text-decoration: underline;
        }
        [data-theme="dark"] .prose code {
            color: #e2e8f0 !important;
            background-color: #334155 !important; /* Lighter slate for contrast */
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
        }
        [data-theme="dark"] .prose pre {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border: 1px solid #334155;
        }

        /* Table Styles (Common) */
        .doc-canvas {
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-radius: 12px;
            padding: 4rem;
            min-height: 80vh;
            position: relative;
            background-image: 
                radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .group-hover-action:hover .actions {
            opacity: 1 !important;
        }
        .prose th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 12px 15px;
            text-align: left;
            font-weight: 700;
            color: #334155;
        }
        .prose td {
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 15px;
            vertical-align: top;
            color: #475569;
        }
        .prose tr:last-child td {
            border-bottom: none;
        }
    </style>
    @endpush
</x-dashboard-layout>
