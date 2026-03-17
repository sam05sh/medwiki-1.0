<!DOCTYPE html>
<html lang="it" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedWiki - Enciclopedia</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=view_sidebar" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=dark_mode" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: {
                medical: { 50: '#f0fdfa', 100: '#ccfbf1', 500: '#14b8a6', 700: '#0f766e', 900: '#134e4a' },
                admin: { 500: '#6366f1', 700: '#4338ca' }
            }}}
        }
    </script>
    </head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-900 dark:text-slate-200 font-sans transition-colors duration-300">
    <div class="pt-16 flex min-h-screen">
        <?php 
        // Example: Include sidebar if on admin page
        if (isset($page) && $page == 'admin') {
            require_once '../app/views/layouts/sidebar.php';
        }
        ?>
        <main class="flex-1 p-4 lg:p-8 w-full max-w-5xl mx-auto">