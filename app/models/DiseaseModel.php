<?php
class DiseaseModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function searchDiseases($query) {
        $sql = "SELECT m.*, c.slug as cat_slug, c.nome as cat_nome 
                FROM malattie m 
                LEFT JOIN categorieMalattie c ON m.categoria_id = c.id 
                WHERE m.nome LIKE :query 
                LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopDiseases($limit = 6) {
        $sql = "SELECT m.*, c.slug as cat_slug 
                FROM malattie m 
                LEFT JOIN categorieMalattie c ON m.categoria_id = c.id 
                ORDER BY m.visite DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        // PDO bindParam is needed for LIMIT
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getBySlug($slug) {
        $stmt = $this->conn->prepare("SELECT m.*, c.nome as cat_nome FROM malattie m LEFT JOIN categorieMalattie c ON m.categoria_id = c.id WHERE m.slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function incrementVisits($id) {
        $stmt = $this->conn->prepare("UPDATE malattie SET visite = visite + 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getAllDiseases() {
        $sql = "SELECT m.*, c.nome as cat_nome 
                FROM malattie m 
                LEFT JOIN categorieMalattie c ON m.categoria_id = c.id 
                ORDER BY m.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveDisease($id, $nome, $slug, $cat_id, $dettagli) {
        if ($id) {
            $sql = "UPDATE malattie SET nome=:nome, slug=:slug, categoria_id=:cat_id, dettagli=:dettagli WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['nome' => $nome, 'slug' => $slug, 'cat_id' => $cat_id, 'dettagli' => $dettagli, 'id' => $id]);
        } else {
            $sql = "INSERT INTO malattie (nome, slug, categoria_id, dettagli) VALUES (:nome, :slug, :cat_id, :dettagli)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['nome' => $nome, 'slug' => $slug, 'cat_id' => $cat_id, 'dettagli' => $dettagli]);
        }
    }

    public function deleteDisease($id) {
        $stmt = $this->conn->prepare("DELETE FROM malattie WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>