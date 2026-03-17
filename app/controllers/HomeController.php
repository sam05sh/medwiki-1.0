<?php
class HomeController extends Controller {
    
    public function index() {
        $diseaseModel = $this->model('DiseaseModel');
        
        $searchQuery = $_GET['q'] ?? '';
        $searchResults = [];
        
        if (!empty($searchQuery)) {
            $searchResults = $diseaseModel->searchDiseases($searchQuery);
        }
        
        $topMalattie = $diseaseModel->getTopDiseases(6);

        $db = new Database();
        $conn = $db->connect();

        $this->view('layouts/header', [
            'page' => 'home',
            'conn' => $conn,  // Pass the connection here
            'currentDiseaseId' => null
        ]);
        $this->view('home', [
            'searchQuery' => $searchQuery,
            'searchResults' => $searchResults,
            'topMalattie' => $topMalattie
        ]);
        $this->view('layouts/footer');
    }
}
?>