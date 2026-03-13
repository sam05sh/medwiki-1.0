<?php 
// No database queries here! 
$jsonDettagli = json_decode($malattia['dettagli'], true);
?>

<div>
    <nav class="text-sm text-slate-500 mb-4"><?= htmlspecialchars($malattia['cat_nome'] ?? 'Generale'); ?></nav>
    <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-8 border-b pb-4">
        <?= htmlspecialchars($malattia['nome']); ?>
    </h1>
    
    <div class="space-y-8">
        <?php if ($jsonDettagli): foreach($jsonDettagli as $k => $v): ?>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h2 class="text-2xl font-bold mb-3 text-medical-600"><?= htmlspecialchars($k); ?></h2>
                <div class="prose dark:prose-invert"><?= nl2br(htmlspecialchars($v)); ?></div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>