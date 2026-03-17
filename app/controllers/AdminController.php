<?php
class AdminController extends Controller {
    
    public function __construct() {
        // Basic auth check for all admin routes except login
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function dashboard() {
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            header("Location: /admin/login");
            exit;
        }

        $diseaseModel = $this->model('DiseaseModel');
        $categoryModel = $this->model('CategoryModel');

        // Note: You'll need to add an getAllDiseases() method to your DiseaseModel!
        $allMalattie = $diseaseModel->getAllDiseases(); 
        $allCats = $categoryModel->getAllCategories();

        $category_tree = [];
        foreach ($allCats as $cat) {
            $parentId = ($cat['parent_id'] === null) ? 'root' : $cat['parent_id'];
            $category_tree[$parentId][] = $cat;
        }

        $this->view('layouts/header', ['page' => 'admin']);
        $this->view('admin/dashboard', [
            'allMalattie' => $allMalattie,
            'category_tree' => $category_tree,
            'allCats' => $allCats
        ]);
        $this->view('layouts/footer');
    }

    public function login() {
        $login_error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../app/config/database.php'; // Or store password in a config file securely
            $admin_password = 'passwordAdmin'; // Remember to hash this in production!
            
            if (isset($_POST['password']) && $_POST['password'] === $admin_password) {
                $_SESSION['is_admin'] = true;
                header("Location: /admin/dashboard");
                exit;
            } else {
                $login_error = "Password errata";
            }
        }

        $this->view('layouts/header', ['page' => 'admin']);
        $this->view('admin/login', ['login_error' => $login_error]);
        $this->view('layouts/footer');
    }

    public function logout() {
        session_destroy();
        header("Location: /");
        exit;
    }

    // --- VIEW ROUTES ---

    public function edit($id = null) {
        if (!isset($_SESSION['is_admin'])) { header("Location: /admin/login"); exit; }
        
        $diseaseModel = $this->model('DiseaseModel');
        $categoryModel = $this->model('CategoryModel');
        
        $editData = null;
        $editDetails = [];
        
        if ($id) {
            // Use the new getById method instead of accessing ->conn directly
            $editData = $diseaseModel->getById($id); 
            if ($editData) {
                $editDetails = json_decode($editData['dettagli'], true);
            }
        }

        $this->view('layouts/header', ['page' => 'admin']);
        $this->view('admin/edit', [
            'editData' => $editData,
            'editDetails' => $editDetails,
            'allCats' => $categoryModel->getAllCategories()
        ]);
        $this->view('layouts/footer');
    }

    // --- POST ACTION Handlers ---

    public function saveDisease() {
        if (!isset($_SESSION['is_admin']) || $_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        
        $id = $_POST['id'] ?? null;
        $nome = trim($_POST['nome']);
        $cat_id = (int)$_POST['categoria_id'];
        $slug = slugify($nome); // Ensure functions.php is loaded!
        
        $dettagli = json_encode(array_filter([
            "Descrizione" => $_POST['descrizione'] ?? '',
            "Sintomi" => $_POST['sintomi'] ?? '',
            "Diagnosi" => $_POST['diagnosi'] ?? '',
            "Terapia" => $_POST['terapia'] ?? ''
        ]), JSON_UNESCAPED_UNICODE);

        $this->model('DiseaseModel')->saveDisease($id, $nome, $slug, $cat_id, $dettagli);
        header("Location: /admin/dashboard");
        exit;
    }

    public function deleteDisease() {
        if (!isset($_SESSION['is_admin']) || $_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        $this->model('DiseaseModel')->deleteDisease((int)$_POST['id']);
        header("Location: /admin/dashboard");
        exit;
    }

    public function saveCategory() {
        if (!isset($_SESSION['is_admin']) || $_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        $nome = trim($_POST['cat_nome']);
        $slug = slugify($nome);
        $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
        
        $this->model('CategoryModel')->addCategory($nome, $slug, $parentId);
        header("Location: /admin/dashboard");
        exit;
    }

    public function deleteCategory() {
        if (!isset($_SESSION['is_admin']) || $_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        $this->model('CategoryModel')->deleteCategory((int)$_POST['cat_id']);
        header("Location: /admin/dashboard");
        exit;
    }
}
?>