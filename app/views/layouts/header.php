<!DOCTYPE html>
<html lang="it" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedWiki - Enciclopedia</title>
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