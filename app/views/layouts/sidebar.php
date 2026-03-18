<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-white dark:bg-surface-dark border-r border-slate-200 dark:border-slate-800 transform -translate-x-full lg:translate-x-0 lg:static lg:block transition-transform duration-300 ease-in-out pt-16 lg:pt-0 overflow-y-auto custom-scroll shadow-2xl lg:shadow-none">
    
    <div class="p-6">
        <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Indice Categorie</h3>
        
        <nav id="sidebarContent" class="text-sm">
        <?php 
            $activeId = isset($currentDiseaseId) ? $currentDiseaseId : null;
            // The logic inside funzioni.php (costruisciAlbero) should be updated to output standard Tailwind classes 
            // rather than raw HTML styles, but it works fine with the baseline CSS if left untouched.
            costruisciAlbero($conn, null, $activeId); 
        ?>
        </nav>
    </div>
</aside>

<div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>