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

        // Pass data to the view
        $this->view('layouts/header', ['page' => 'home']);
        $this->view('home', [
            'searchQuery' => $searchQuery,
            'searchResults' => $searchResults,
            'topMalattie' => $topMalattie
        ]);
        $this->view('layouts/footer');
    }
}
?>