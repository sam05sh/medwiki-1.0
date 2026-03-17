<div class="max-w-md mx-auto mt-20 bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border">
    <h1 class="text-2xl font-bold mb-6 text-center">Accesso Admin</h1>
    
    <?php if(!empty($login_error)): ?>
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm"><?= htmlspecialchars($login_error) ?></div>
    <?php endif; ?>

    <form action="/admin/login" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg p-2 dark:bg-slate-700 dark:border-slate-600" required>
        </div>
        <button type="submit" class="w-full bg-medical-500 text-white px-4 py-2 rounded-lg hover:bg-medical-600">Accedi</button>
    </form>
</div>