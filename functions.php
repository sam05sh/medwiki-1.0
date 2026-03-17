<?php
// functions.php

// Funzione per creare slug URL-friendly (es. "Mal di Gola" -> "mal-di-gola")
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    return strtolower(trim($text, '-'));
}

/**
 * Costruisce l'albero passando il "path" accumulato dai genitori.
 * $currentPathUrl: es. "/it/cardiologia"
 */
/**
 * Costruisce l'albero passando il "path" accumulato dai genitori.
 */
function costruisciAlbero($pdo, $parentId = null, $activeId = null, $currentPathUrl = '') {
    $sql = "SELECT * FROM categorieMalattie WHERE parent_id " . ($parentId === null ? "IS NULL" : "= :parent_id") . " ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    if ($parentId !== null) $stmt->bindValue(':parent_id', $parentId, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo '<ul class="pl-4 border-l border-slate-200 ml-2 space-y-1">';
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $catSlug = !empty($row['slug']) ? $row['slug'] : slugify($row['nome']);
            $thisCatPath = $currentPathUrl . '/' . $catSlug;

            // Fetch subcategories
            $checkChild = $pdo->prepare("SELECT id FROM categorieMalattie WHERE parent_id = :id");
            $checkChild->execute(['id' => $row['id']]);
            $hasChildren = $checkChild->rowCount() > 0;

            // Fetch diseases in this category
            $mStmt = $pdo->prepare("SELECT id, nome, slug FROM malattie WHERE categoria_id = :id ORDER BY nome ASC");
            $mStmt->execute(['id' => $row['id']]);
            $diseases = $mStmt->fetchAll(PDO::FETCH_ASSOC);

            // Group into <details> if it contains subcategories OR diseases
            if ($hasChildren || count($diseases) > 0) {
                // FIXED: Added id="cat-ID" so localStorage correctly remembers accordion state
                echo '<details class="group" id="cat-'.$row['id'].'">';
                echo '<summary class="cursor-pointer text-sm font-medium py-1">'.htmlspecialchars($row['nome']).'</summary>';
                
                if ($hasChildren) {
                    costruisciAlbero($pdo, $row['id'], $activeId, $thisCatPath);
                }
                
                if (count($diseases) > 0) {
                    echo '<ul class="pl-4 space-y-1 mt-1 border-l border-slate-100 dark:border-slate-700">';
                    foreach($diseases as $m){
                        $mSlug = !empty($m['slug']) ? $m['slug'] : slugify($m['nome']);
                        $fullUrl = "/it" . $thisCatPath . "/" . $mSlug;
                        
                        // FIXED: Applies the active ID marker so the JS can automatically expand the tree
                        $isActive = ($activeId == $m['id']);
                        $idAttr = $isActive ? ' id="active-disease-link"' : '';
                        $cssClass = $isActive ? 'text-medical-600 font-bold text-xs' : 'text-teal-600 dark:text-teal-400 text-xs hover:underline';
                        
                        echo '<li><a href="'.$fullUrl.'"'.$idAttr.' class="'.$cssClass.'">'.htmlspecialchars($m['nome']).'</a></li>';
                    }
                    echo '</ul>';
                }
                
                echo '</details>';
            } else {
                // Empty category
                echo '<div class="font-medium text-sm py-1 text-slate-400">'.htmlspecialchars($row['nome']).'</div>';
            }
        }
        echo '</ul>';
    }
}


// Helper per le select (invariato)
function getCategoryOptions($pdo, $parentId = null, $prefix = '', $selectedId = null) {
    $sql = "SELECT * FROM categorieMalattie WHERE parent_id " . ($parentId === null ? "IS NULL" : "= :parent_id");
    $stmt = $pdo->prepare($sql);
    if ($parentId !== null) $stmt->bindValue(':parent_id', $parentId, PDO::PARAM_INT);
    $stmt->execute();

    $html = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selected = ($row['id'] == $selectedId) ? 'selected' : '';
        $html .= '<option value="'.$row['id'].'" '.$selected.'>'.$prefix . htmlspecialchars($row['nome']).'</option>';
        $html .= getCategoryOptions($pdo, $row['id'], $prefix . '&mdash; ', $selectedId);
    }
    return $html;
}


function renderDeleteButton($id) {
    ?>
    <form method="POST" onsubmit="return confirm('Eliminare questa categoria?');" class="flex items-center">
        <input type="hidden" name="action" value="delete_category">
        <input type="hidden" name="cat_id" value="<?php echo (int)$id; ?>">
        <button type="submit" 
                class="text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 w-6 h-6 rounded flex items-center justify-center transition-colors" 
                title="Elimina">
            ✕
        </button>
    </form>
    <?php
}

function renderCategoryLevel($parentId, $level, $category_tree) {
    if (!isset($category_tree[$parentId])) return;

    foreach ($category_tree[$parentId] as $cat) {
        $indent = $level * 4; // Increases padding-left based on depth
        $isParent = ($level === 0);
        ?>
        
        <div class="flex justify-between items-center text-sm border-b dark:border-slate-700 pb-1 last:border-0 hover:bg-slate-50 dark:hover:bg-slate-700/30 p-1 rounded" 
             style="padding-left: <?php echo $indent; ?>px;">
            
            <span class="truncate <?php echo $isParent ? 'font-semibold text-slate-700 dark:text-slate-300' : 'text-slate-500'; ?>">
                <?php 
                    echo ($level > 0 ? str_repeat('  ', $level) . '↳ ' : ''); 
                    echo htmlspecialchars($cat['nome']); 
                ?>
            </span>
            <form action="/admin/deleteCategory" method="POST" onsubmit="return confirm('Eliminare questa categoria?');" class="flex items-center">
                <input type="hidden" name="cat_id" value="<?php echo (int)$cat['id']; ?>">
                <button type="submit" class="text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 w-6 h-6 rounded flex items-center justify-center transition-colors">
                    ✕
                </button>
            </form>
        </div>

        <?php
        // RECURSION: Look for children of the category we just printed
        renderCategoryLevel($cat['id'], $level + 1, $category_tree);
    }
}

?>
