<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Site Under Maintenance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --blueprint: #1a1508;
            --grid-line: rgba(212, 175, 55, 0.14);
            --cyan: #d4af37;
            --amber: #e6c358;
            --ink: #F5EFDD;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--blueprint);
            background-image:
                linear-gradient(var(--grid-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .font-mono-tech {
            font-family: 'Space Mono', monospace;
        }

        .gear {
            animation: spin 12s linear infinite;
            transform-origin: 50% 50%;
        }

        .gear-reverse {
            animation: spin-reverse 9s linear infinite;
            transform-origin: 50% 50%;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-reverse {
            from {
                transform: rotate(360deg);
            }

            to {
                transform: rotate(0deg);
            }
        }

        .sweep-arc {
            stroke-dasharray: 8 6;
            animation: dash 20s linear infinite;
        }

        @keyframes dash {
            to {
                stroke-dashoffset: -400;
            }
        }

        .status-dot {
            animation: pulse-dot 1.6s ease-in-out infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.25;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .gear,
            .gear-reverse,
            .sweep-arc,
            .status-dot {
                animation: none !important;
            }
        }

        .corner-mark {
            border-color: rgba(212, 175, 55, 0.35);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center text-[var(--ink)] px-6 py-12 relative overflow-hidden">

    <div class="hidden sm:block absolute top-6 left-6 w-10 h-10 border-l-2 border-t-2 corner-mark"></div>
    <div class="hidden sm:block absolute top-6 right-6 w-10 h-10 border-r-2 border-t-2 corner-mark"></div>
    <div class="hidden sm:block absolute bottom-6 left-6 w-10 h-10 border-l-2 border-b-2 corner-mark"></div>
    <div class="hidden sm:block absolute bottom-6 right-6 w-10 h-10 border-r-2 border-b-2 corner-mark"></div>

    <div class="hidden md:block absolute top-10 left-10 font-mono-tech text-[11px] tracking-widest text-[var(--cyan)]/60 uppercase">
        Sheet 01 / Site Systems
    </div>
    <div class="hidden md:block absolute bottom-10 right-10 font-mono-tech text-[11px] tracking-widest text-[var(--cyan)]/60 uppercase text-right">
        Rev. <?php echo date('Y-m-d'); ?>
    </div>

    <main class="relative z-10 max-w-xl w-full text-center">

        <!-- Site Logo -->
        <img src="/frontend/assets/images/logo_white.png" alt="Alpha Innovators" class="max-w-[300px] mx-auto mb-10 opacity-90" onerror="this.style.display='none'">

        <div class="relative w-40 h-40 mx-auto mb-10">
            <svg viewBox="0 0 200 200" class="w-full h-full">
                <circle cx="100" cy="100" r="92" fill="none" stroke="var(--cyan)" stroke-opacity="0.15" stroke-width="1" />
                <circle cx="100" cy="100" r="78" fill="none" stroke="var(--cyan)" stroke-opacity="0.35" stroke-width="1.5" class="sweep-arc" />

                <g class="gear" transform="translate(78,78)">
                    <path fill="var(--cyan)" d="M22 0 L26 0 L27.5 7 A16 16 0 0 1 33 9.5 L38.5 5 L41.5 8 L37 13.5 A16 16 0 0 1 39.5 19 L46.5 20.5 L46.5 24.5 L39.5 26 A16 16 0 0 1 37 31.5 L41.5 37 L38.5 40 L33 35.5 A16 16 0 0 1 27.5 38 L26 45 L22 45 L20.5 38 A16 16 0 0 1 15 35.5 L9.5 40 L6.5 37 L11 31.5 A16 16 0 0 1 8.5 26 L1.5 24.5 L1.5 20.5 L8.5 19 A16 16 0 0 1 11 13.5 L6.5 8 L9.5 5 L15 9.5 A16 16 0 0 1 20.5 7 Z" />
                    <circle cx="24" cy="22.5" r="9" fill="var(--blueprint)" />
                </g>

                <g class="gear-reverse" transform="translate(112,108)">
                    <path fill="var(--amber)" d="M15 0 L18 0 L19 5 A11 11 0 0 1 22.5 6.5 L26.5 3.3 L28.6 5.4 L25.5 9.5 A11 11 0 0 1 27 13 L32 14 L32 17 L27 18 A11 11 0 0 1 25.5 21.5 L28.6 25.6 L26.5 27.7 L22.5 24.5 A11 11 0 0 1 19 26 L18 31 L15 31 L14 26 A11 11 0 0 1 10.5 24.5 L6.5 27.7 L4.4 25.6 L7.5 21.5 A11 11 0 0 1 6 18 L1 17 L1 14 L6 13 A11 11 0 0 1 7.5 9.5 L4.4 5.4 L6.5 3.3 L10.5 6.5 A11 11 0 0 1 14 5 Z" />
                    <circle cx="16.5" cy="15.5" r="6" fill="var(--blueprint)" />
                </g>
            </svg>
        </div>

        <p class="font-mono-tech text-xs tracking-[0.3em] text-[var(--amber)] uppercase mb-4 flex items-center justify-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[var(--amber)] status-dot"></span>
            Status: Under Maintenance
        </p>

        <h1 class="font-mono-tech text-3xl sm:text-4xl font-bold tracking-tight mb-4">
            We&rsquo;re tightening a few bolts.
        </h1>

        <p class="text-base sm:text-lg text-[var(--ink)]/70 leading-relaxed max-w-md mx-auto">
            Scheduled maintenance is underway. The site will be back online shortly &mdash; thanks for your patience while we get things running smoothly again.
        </p>

        <div class="mt-10 inline-flex items-center gap-3 font-mono-tech text-[11px] tracking-widest text-[var(--cyan)]/70 uppercase border border-[var(--cyan)]/20 rounded-full px-5 py-2">
            <span class="w-1.5 h-1.5 rounded-full bg-[var(--cyan)] status-dot"></span>
            Estimated return: soon
        </div>

    </main>
</body>

</html>