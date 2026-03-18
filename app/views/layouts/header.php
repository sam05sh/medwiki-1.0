<!DOCTYPE html>
<html lang="it" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedWiki - Enciclopedia Medica Affidabile</title>
    <meta name="description" content="Informazioni mediche libere, affidabili e accessibili.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { 
                extend: { 
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        medical: { 50: '#f0fdfa', 100: '#ccfbf1', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e', 900: '#134e4a' },
                        surface: { light: '#ffffff', dark: '#0f172a' }
                    }
                }
            }
        }
    </script>
    <style>
        /* Minimal custom CSS, relying mostly on Tailwind */
        details > summary::-webkit-details-marker { display: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 dark:bg-surface-dark dark:text-slate-200 transition-colors duration-300 min-h-screen flex flex-col">
    
    <nav class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-surface-dark/80 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <div class="flex items-center gap-4">
                <?php if ($page != 'admin'): ?>
                    <button id="mobileMenuBtn" class="lg:hidden p-2 text-slate-500 hover:text-medical-600 focus:outline-none focus:ring-2 focus:ring-medical-500 rounded-lg" aria-label="Apri menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                <?php endif; ?>
                
                <a href="/" class="flex items-center gap-2 group">
                    <div class="bg-medical-600 text-white p-1.5 rounded-lg group-hover:bg-medical-500 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">health_and_safety</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">MedWiki</span>
                </a>
            </div>

            <?php if ($page != 'admin'): ?>
            <div class="hidden lg:flex items-center gap-8">
                <a href="/" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-medical-600 dark:hover:text-medical-400 transition-colors">Home</a>
                <button id="desktopSidebarToggle" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-medical-600 dark:hover:text-medical-400 transition-colors flex items-center gap-1">
                    Esplora Indice
                </button>
            </div>

            <div class="flex items-center gap-4">
                <form action="/" method="GET" class="hidden md:flex relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    <input type="text" name="q" placeholder="Cerca patologia..." class="w-64 bg-slate-100 dark:bg-slate-800 border border-transparent focus:border-medical-500 rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-medical-500/20 outline-none transition-all placeholder-slate-400 text-slate-900 dark:text-white">
                </form>
                <button id="themeToggle" class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" aria-label="Cambia tema">
                    <span class="material-symbols-outlined" id="themeIcon">light_mode</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="flex-1 flex max-w-7xl mx-auto w-full">
        <?php if ($page == 'admin'): ?>
            <?php include __DIR__ . '/sidebar.php'; ?> 
        <?php endif; ?>
        
        <main class="flex-1 w-full p-4 lg:p-8 overflow-x-hidden">