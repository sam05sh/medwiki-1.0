<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Gestione Malattie</h2>
            <a href="/admin/edit" class="bg-medical-500 text-white px-4 py-2 rounded-lg text-sm">+ Nuova Malattia</a>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-slate-400 text-xs uppercase border-b dark:border-slate-700">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Categoria</th>
                    <th class="px-4 py-2 text-right">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allMalattie as $m): ?>
                <tr class="border-b dark:border-slate-700 hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-xs"><?= $m['id']; ?></td>
                    <td class="px-4 py-3 font-medium"><?= htmlspecialchars($m['nome']); ?></td>
                    <td class="px-4 py-3 text-slate-500"><?= htmlspecialchars($m['cat_nome'] ?? 'Nessuna'); ?></td>
                    <td class="px-4 py-3 text-right">
                        <a href="/admin/edit/<?= $m['id']; ?>" class="text-blue-500 mr-2">Modifica</a>
                        <form action="/admin/deleteDisease" method="POST" class="inline" onsubmit="return confirm('Sicuro?');">
                            <input type="hidden" name="id" value="<?= $m['id']; ?>">
                            <button class="text-red-500">Elimina</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border p-6">
        <h2 class="text-xl font-bold mb-6">Categorie</h2>
        <div class="space-y-4 mb-6">
            <?php renderCategoryLevel('root', 0, $category_tree); ?>
        </div>
        
        <form action="/admin/saveCategory" method="POST" class="pt-4 border-t space-y-3">
            <input type="text" name="cat_nome" placeholder="Nuova categoria..." class="w-full border rounded-lg p-2 text-sm" required>
            <select name="parent_id" class="w-full border rounded-lg p-2 text-sm">
                <option value="">Senza genitore (Principale)</option>
                <?php foreach($allCats as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="w-full bg-slate-800 text-white py-2 rounded-lg text-sm">Aggiungi Categoria</button>
        </form>
    </div>
</div>