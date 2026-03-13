<?php
class CategoryModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categorieMalattie ORDER BY parent_id ASC, nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCategory($nome, $slug, $parentId) {
        $sql = "INSERT INTO categorieMalattie (nome, slug, parent_id) VALUES (:nome, :slug, :parent_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'nome' => $nome,
            'slug' => $slug,
            'parent_id' => $parentId ? $parentId : null
        ]);
    }

    public function deleteCategory($id) {
        // Check if it has children or diseases attached
        $sql = "SELECT id FROM malattie WHERE categoria_id = :id 
                UNION 
                SELECT id FROM categorieMalattie WHERE parent_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() == 0) {
            $delStmt = $this->conn->prepare("DELETE FROM categorieMalattie WHERE id = :id");
            $delStmt->execute(['id' => $id]);
        }
    }
}
?>