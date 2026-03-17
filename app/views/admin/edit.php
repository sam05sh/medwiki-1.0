<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6"><?= $editData ? 'Modifica' : 'Aggiungi' ?> Malattia</h1>
    
    <form action="/admin/saveDisease" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Nome Malattia</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($editData['nome'] ?? '') ?>" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Categoria</label>
            <select name="categoria_id" class="w-full border rounded-lg p-2">
                <?php foreach($allCats as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($editData['categoria_id']) && $editData['categoria_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php 
        $sections = ['Descrizione', 'Sintomi', 'Diagnosi', 'Terapia'];
        foreach($sections as $s): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700"><?= $s ?></label>
                <textarea name="<?= strtolower($s) ?>" rows="4" class="w-full border rounded-lg p-2"><?= htmlspecialchars($editDetails[$s] ?? '') ?></textarea>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Salva Modifiche</button>
    </form>
</div>