<div class="py-12 lg:py-24 flex flex-col items-center text-center animate-fade-in max-w-3xl mx-auto">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-medical-50 dark:bg-medical-900/30 text-medical-700 dark:text-medical-300 text-sm font-medium mb-6">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-medical-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-medical-500"></span>
        </span>
        Aggiornato e verificato
    </div>
    
    <h1 class="text-4xl lg:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-6">
        Conoscenza medica <br/>
        <span class="text-medical-600 dark:text-medical-400">alla portata di tutti.</span>
    </h1>
    
    <p class="text-lg text-slate-600 dark:text-slate-400 mb-10 max-w-2xl">
        Esplora la nostra enciclopedia libera per trovare informazioni chiare, affidabili e aggiornate su patologie, sintomi e percorsi diagnostici.
    </p>

    <form action="/" method="GET" class="w-full relative shadow-lg shadow-slate-200/50 dark:shadow-none rounded-full">
        <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-6 text-slate-400 text-2xl">search</span>
            <input type="text" name="q" value="<?= htmlspecialchars($searchQuery ?? '') ?>" placeholder="Cerca una malattia (es. Ipertensione, Diabete)..." 
                class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full py-5 pl-14 pr-32 text-lg focus:ring-4 focus:ring-medical-500/10 focus:border-medical-500 outline-none transition-all text-slate-900 dark:text-white">
            <button type="submit" class="absolute right-2 top-2 bottom-2 bg-medical-600 hover:bg-medical-700 text-white px-6 rounded-full font-medium transition-colors">
                Cerca
            </button>
        </div>
    </form>

    <?php if(!empty($searchResults)): ?>
        <div class="w-full text-left mt-8">
            <h3 class="text-sm font-semibold text-slate-500 dark:text-slate-400 mb-3 uppercase tracking-wider">Risultati della ricerca</h3>
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden divide-y divide-slate-100 dark:divide-slate-700 shadow-sm">
                <?php foreach($searchResults as $res): 
                    $url = "/it/" . (!empty($res['cat_slug']) ? $res['cat_slug'] : 'generale') . "/" . (!empty($res['slug']) ? $res['slug'] : slugify($res['nome']));
                ?>
                    <a href="<?= $url ?>" class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                        <span class="font-medium text-slate-900 dark:text-white group-hover:text-medical-600 dark:group-hover:text-medical-400 transition-colors"><?= htmlspecialchars($res['nome']) ?></span>
                        <span class="text-xs font-medium text-slate-500 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 rounded-md"><?= htmlspecialchars($res['cat_nome'] ?? 'Generale') ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="pb-16 max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <span class="material-symbols-outlined text-medical-500">trending_up</span>
            Articoli più consultati
        </h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($topMalattie as $tm): 
             $url = "/it/" . (!empty($tm['cat_slug']) ? $tm['cat_slug'] : 'consultazione') . "/" . (!empty($tm['slug']) ? $tm['slug'] : slugify($tm['nome']));
        ?>
        <a href="<?= $url ?>" class="group flex flex-col justify-between p-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:border-medical-500 dark:hover:border-medical-500 hover:shadow-xl hover:shadow-medical-500/5 transition-all duration-300 hover:-translate-y-1">
            <div>
                <div class="w-10 h-10 rounded-full bg-medical-50 dark:bg-medical-900/30 text-medical-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[20px]">medical_services</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-2"><?= htmlspecialchars($tm['nome']) ?></h3>
            </div>
            <div class="mt-6 flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-[16px] mr-1">visibility</span>
                <span><?= number_format($tm['visite']) ?> consultazioni</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>