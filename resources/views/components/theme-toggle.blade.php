{{-- Theme Toggle Component for Ketik.in --}}
<div class="theme-toggle-wrapper">
    <button type="button" class="theme-toggle js-theme-toggle" aria-label="Toggle theme">
        <div class="theme-toggle-slider">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sun" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon-moon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </div>
    </button>
</div>

@once
<script>
    if (!window.KetikTheme) {
        window.KetikTheme = (function() {
            // Get theme from localStorage or default to light
            const getTheme = () => localStorage.getItem('theme') || 'light';
            
            const updateIcons = (theme) => {
                const toggles = document.querySelectorAll('.js-theme-toggle');
                toggles.forEach(btn => {
                    const sunIcon = btn.querySelector('.icon-sun');
                    const moonIcon = btn.querySelector('.icon-moon');
                    
                    if (theme === 'dark') {
                        sunIcon.style.display = 'none';
                        moonIcon.style.display = 'block';
                    } else {
                        sunIcon.style.display = 'block';
                        moonIcon.style.display = 'none';
                    }
                });
            };

            const setTheme = (theme) => {
                localStorage.setItem('theme', theme);
                document.documentElement.setAttribute('data-theme', theme);
                updateIcons(theme);
            };

            const toggle = () => {
                const newTheme = getTheme() === 'light' ? 'dark' : 'light';
                setTheme(newTheme);
            };

            const init = () => {
                const currentTheme = getTheme();
                setTheme(currentTheme);

                document.addEventListener('click', function(e) {
                    if (e.target.closest('.js-theme-toggle')) {
                        toggle();
                    }
                });
            };

            return { init };
        })();

        document.addEventListener('DOMContentLoaded', window.KetikTheme.init);
    }
</script>
@endonce

<style>
    .theme-toggle-wrapper {
        display: inline-block;
        vertical-align: middle;
    }

    .theme-toggle {
        position: relative;
        width: 56px;
        height: 28px;
        background-color: rgba(0,0,0,0.1);
        border-radius: 20px;
        cursor: pointer;
        border: 2px solid transparent; 
        transition: all 0.3s ease;
        padding: 0;
        overflow: visible;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }
    
    [data-theme="light"] .theme-toggle {
        background-color: #E2E8F0;
        border-color: #CBD5E1;
    }

    [data-theme="dark"] .theme-toggle {
        background-color: #1F2937;
        border-color: #374151;
    }

    .theme-toggle:hover {
        border-color: var(--ketik-accent, #3D91D6);
    }

    .theme-toggle-slider {
        position: absolute;
        top: 1px;
        left: 1px;
        width: 22px;
        height: 22px;
        background: linear-gradient(135deg, #3D91D6 0%, #245C8A 100%);
        border-radius: 50%;
        transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 10;
    }

    [data-theme="dark"] .theme-toggle-slider {
        transform: translateX(28px);
        background: linear-gradient(135deg, #8FBADC 0%, #3D91D6 100%);
        color: #070D12;
    }

    .theme-toggle-slider svg {
        width: 14px;
        height: 14px;
    }
</style>
