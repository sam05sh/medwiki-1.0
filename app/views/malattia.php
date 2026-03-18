<?php $jsonDettagli = json_decode($malattia['dettagli'], true); ?>

<article class="max-w-3xl mx-auto py-8">
    <nav class="flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 mb-6 space-x-2">
        <a href="/" class="hover:text-medical-600 dark:hover:text-medical-400">Home</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span><?= htmlspecialchars($malattia['cat_nome'] ?? 'Generale'); ?></span>
    </nav>

    <header class="mb-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-4">
            <?= htmlspecialchars($malattia['nome']); ?>
        </h1>
        <div class="flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700 pb-6">
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">update</span>
                <span>Ultimo aggiornamento recente</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">visibility</span>
                <span><?= number_format($malattia['visite']) ?> letture</span>
            </div>
        </div>
    </header>
    
    <div class="space-y-10">
        <?php 
        // Mapping section names to appropriate icons for visual hierarchy
        $icons = [
            'Descrizione' => 'info',
            'Sintomi' => 'personal_injury',
            'Diagnosi' => 'biotech',
            'Terapia' => 'vaccines'
        ];

        if ($jsonDettagli): foreach($jsonDettagli as $k => $v): 
            if (empty(trim($v))) continue;
            $icon = $icons[$k] ?? 'article';
        ?>
            <section class="scroll-mt-24" id="<?= strtolower($k) ?>">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-medical-50 dark:bg-medical-900/20 text-medical-600 dark:text-medical-400 rounded-lg">
                        <span class="material-symbols-outlined"><?= $icon ?></span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($k); ?></h2>
                </div>
                
                <div class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <?= nl2br(htmlspecialchars($v)); ?>
                </div>
            </section>
        <?php endforeach; endif; ?>
    </div>

    <div class="mt-12 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-700 text-sm text-slate-500 dark:text-slate-400 text-center">
        <strong>Disclaimer Medico:</strong> Le informazioni contenute su MedWiki hanno esclusivamente scopo informativo e non sostituiscono in alcun modo il parere di un medico professionista.
    </div>
</article>