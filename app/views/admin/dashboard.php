<tbody>
    <?php foreach($allMalattie as $m): ?>
    <tr class="border-b dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
        <td class="px-4 py-3 text-slate-400 font-mono"><?= $m['id']; ?></td>
        <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-200"><?= htmlspecialchars($m['nome']); ?></td>
        <td class="px-4 py-3 text-slate-500"><?= htmlspecialchars($m['cat_nome'] ?? 'Nessuna'); ?></td>
        <td class="px-4 py-3 text-right space-x-2">
            <a href="/admin/edit/<?= $m['id']; ?>" class="text-blue-500 hover:underline font-medium">Modifica</a>
            <form action="/admin/deleteDisease" method="POST" class="inline" onsubmit="return confirm('Sicuro?');">
                <input type="hidden" name="id" value="<?= $m['id']; ?>">
                <button class="text-red-500 hover:underline">Elimina</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

<form action="/admin/saveCategory" method="POST" class="space-y-3">
    </form>