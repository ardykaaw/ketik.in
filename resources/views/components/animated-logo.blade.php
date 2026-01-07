@props(['height' => '64px', 'color' => null])

<div {{ $attributes->merge(['class' => 'animated-logo-container d-inline-flex align-items-center']) }} style="height: {{ $height }}; gap: 2px;">
    <!-- Icon "K" (Typography Style) -->
    <div class="logo-icon-text d-flex align-items-center justify-content-center" 
         style="
            height: {{ $height }}; 
            flex-shrink: 0;
            position: relative;
         ">
         <span style="
            font-family: 'Inter', sans-serif; 
            font-weight: 800; 
            color: {{ $color ?? 'var(--tblr-heading-color, #0c151d)' }}; 
            font-size: calc({{ $height }} * 0.9); /* Large K */
            line-height: 1;
            letter-spacing: -0.05em;
         ">K</span>
    </div>

    <!-- Text "etik.in" -->
    <div class="logo-text-wrapper" style="position: relative; height: {{ $height ?? '64px' }}; display: flex; align-items: center; margin-left: -2px; padding-top: calc({{ $height ?? '64px' }} * 0.28);">
        <span class="logo-text-static" style="
            font-family: 'Inter', sans-serif; 
            font-weight: 700; 
            font-size: calc({{ $height }} * 0.45); 
            color: {{ $color ?? 'var(--tblr-heading-color, #0c151d)' }};
            letter-spacing: -0.02em;
            display: inline-block;
            white-space: nowrap;
        ">
            etik.in
        </span>
        <span class="logo-cursor" style="
            font-family: 'Inter', sans-serif; 
            font-weight: 400; 
            font-size: calc({{ $height }} * 0.45); 
            color: {{ $color ?? 'var(--ketik-accent, #297dc2)' }};
            margin-left: 2px;
        ">|</span>
    </div>
</div>

<style>
    /* Typewriter Text Animation */
    .logo-text-wrapper {
        overflow: hidden;
    }
    
    .logo-text-static {
        overflow: hidden;
        border-right: .15em solid transparent; 
        max-width: 0;
        animation: typing-alive 6s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }

    .logo-cursor {
        animation: blink-caret 1s step-end infinite;
    }

    @keyframes typing-alive {
        0%, 5% { max-width: 0; }
        40%, 90% { max-width: 100%; }
        100% { max-width: 100%; }
    }

    @keyframes blink-caret {
        from, to { opacity: 0; }
        50% { opacity: 1; }
    }
    
    /* Dark Mode Global Support if color not forced */
    [data-theme="dark"] .logo-text-static,
    [data-theme="dark"] .logo-icon-text span {
        color: {{ $color ?? '#e2ebf3' }};
    }
</style>
