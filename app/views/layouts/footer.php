</main>
    </div> <footer class="bg-white dark:bg-surface-dark border-t border-slate-200 dark:border-slate-800 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">
                &copy; <?= date('Y') ?> MedWiki. Tutti i diritti riservati.
            </p>
            <p class="text-slate-400 dark:text-slate-500 text-xs mt-2">
                Progetto open source dedicato all'educazione medica.
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // --- 1. Theme Toggle Logic ---
            const htmlEl = document.documentElement; 
            const themeBtn = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');

            function updateThemeIcon() {
                if(!themeIcon) return;
                themeIcon.textContent = htmlEl.classList.contains('dark') ? 'light_mode' : 'dark_mode';
            }

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                htmlEl.classList.add('dark');
            } else {
                htmlEl.classList.remove('dark');
            }
            updateThemeIcon();

            if(themeBtn) {
                themeBtn.addEventListener('click', () => {
                    htmlEl.classList.toggle('dark');
                    localStorage.theme = htmlEl.classList.contains('dark') ? 'dark' : 'light';
                    updateThemeIcon();
                });
            }

            // --- 2. Sidebar & Mobile Menu Logic ---
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const desktopToggleBtn = document.getElementById('desktopSidebarToggle');

            function toggleMobileSidebar() {
                if(!sidebar || !overlay) return;
                const isClosed = sidebar.classList.contains('-translate-x-full');
                if (isClosed) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }

            if(mobileBtn) mobileBtn.addEventListener('click', toggleMobileSidebar);
            if(overlay) overlay.addEventListener('click', toggleMobileSidebar);
            
            // Desktop toggle (collapses sideways)
            if(desktopToggleBtn && sidebar) {
                desktopToggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('lg:hidden');
                });
            }

            // --- 3. Tree Navigation Persistence ---
            const storageKey = 'medwiki_tree_state';
            const savedState = JSON.parse(localStorage.getItem(storageKey) || "[]");
            
            // Restore Open States
            savedState.forEach(id => {
                const el = document.getElementById(id);
                if(el && el.tagName === 'DETAILS') el.open = true;
            });

            // Auto-expand Active Disease
            const activeLink = document.getElementById('active-disease-link');
            if (activeLink) {
                let parent = activeLink.closest('details');
                while (parent) {
                    parent.open = true;
                    if (!savedState.includes(parent.id)) savedState.push(parent.id);
                    parent = parent.parentElement.closest('details');
                }
                localStorage.setItem(storageKey, JSON.stringify(savedState));
                // Scroll into view gently
                activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            // Listen to tree toggles
            document.querySelectorAll('details').forEach(detail => {
                detail.addEventListener('toggle', () => {
                    let currentState = JSON.parse(localStorage.getItem(storageKey) || "[]");
                    if(detail.open && detail.id) {
                        if(!currentState.includes(detail.id)) currentState.push(detail.id);
                    } else if (!detail.open && detail.id) {
                        currentState = currentState.filter(id => id !== detail.id);
                    }
                    localStorage.setItem(storageKey, JSON.stringify(currentState));
                });
            });
        });
    </script>
</body>
</html>