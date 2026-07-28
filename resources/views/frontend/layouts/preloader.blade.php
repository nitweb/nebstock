<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="animation-preloader">
            <div class="logo-circle">
                <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Logo">
            </div>
            <div class="loading-dots">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</div>

<style>
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: #1A1A1A;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ctn-preloader {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: #1A1A1A;
    }

    .animation-preloader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 25px;
        z-index: 100;
        position: relative;
    }

    .logo-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: #FAF7F2;
        border: 5px solid #B8860B;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        animation: pulse 1.5s ease-in-out infinite;
    }

    .logo-circle img {
        width: 80%;
        height: 80%;
        object-fit: contain;
    }

    .loading-dots {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .loading-dots span {
        display: inline-block;
        width: 4px;
        border-radius: 2px;
        background: #B8860B;
        animation: bar-bounce 1s ease-in-out infinite;
    }

    .loading-dots span:nth-child(1) {
        height: 20px;
        animation-delay: 0s;
    }

    .loading-dots span:nth-child(2) {
        height: 30px;
        animation-delay: 0.15s;
    }

    .loading-dots span:nth-child(3) {
        height: 20px;
        animation-delay: 0.3s;
    }

    .loading-dots span:nth-child(4) {
        height: 30px;
        animation-delay: 0.45s;
    }

    @keyframes bar-bounce {

        0%,
        100% {
            transform: scaleY(1);
            opacity: 0.5;
        }

        50% {
            transform: scaleY(1.5);
            opacity: 1;
        }
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(184, 134, 11, 0.5);
        }

        50% {
            box-shadow: 0 0 0 15px rgba(184, 134, 11, 0);
        }
    }

    #preloader.loaded {
        opacity: 0;
        visibility: hidden;
        transition: 0.5s ease-out;
    }
</style>

<script>
    // If already visited this session, hide preloader instantly
    if (sessionStorage.getItem('preloader_shown')) {
        document.getElementById('preloader').style.display = 'none';
    }
</script>
