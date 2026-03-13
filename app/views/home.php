<div class="text-center py-12 lg:py-20 animate-fade-in">
    <h1 class="text-4xl lg:text-6xl font-extrabold text-slate-900 dark:text-white mb-6">
        Enciclopedia <span class="text-transparent bg-clip-text bg-gradient-to-r from-medical-500 to-blue-600">Medica</span>
    </h1>
    
    <form action="/" method="GET" class="relative max-w-xl mx-auto mb-12">
        <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Cerca es. 'Ipertensione'..." class="...">
    </form>

    <?php if(!empty($searchResults)): ?>
        <div class="text-left max-w-xl mx-auto mb-12">
            <h3 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Risultati Ricerca</h3>
            <div class="bg-white rounded-xl shadow border overflow-hidden">
                <?php foreach($searchResults as $res): 
                    $mSlug = !empty($res['slug']) ? $res['slug'] : slugify($res['nome']);
                    $cSlug = !empty($res['cat_slug']) ? $res['cat_slug'] : 'generale';
                    $url = "/it/" . $cSlug . "/" . $mSlug;
                ?>
                    <a href="<?= $url ?>" class="block px-6 py-3 border-b hover:bg-slate-50 transition-colors group">
                        <span class="font-semibold text-medical-600"><?= htmlspecialchars($res['nome']) ?></span>
                        <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-full"><?= htmlspecialchars($res['cat_nome'] ?? 'Generale') ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="mb-8">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">🔥 Più Consultate</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($topMalattie as $tm): 
             $mSlug = !empty($tm['slug']) ? $tm['slug'] : slugify($tm['nome']);
             $cSlug = !empty($tm['cat_slug']) ? $tm['cat_slug'] : 'consultazione'; 
             $url = "/it/" . $cSlug . "/" . $mSlug;
        ?>
        <a href="<?= $url ?>" class="group block p-6 bg-white rounded-2xl border hover:border-medical-500 transition-all shadow-lg relative overflow-hidden">
            <h3 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($tm['nome']) ?></h3>
            <div class="mt-4 text-xs text-slate-400">
                <span><?= $tm['visite'] ?> visite</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>