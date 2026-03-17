<?php
class DiseaseController extends Controller {
    
    public function show($slug) {
        $diseaseModel = $this->model('DiseaseModel');
        $malattia = $diseaseModel->getBySlug($slug);
        
        if (!$malattia) {
            // Handle 404
            $this->view('layouts/header', ['page' => '404']);
            echo "<div class='text-center py-20'><h1 class='text-6xl font-bold'>404</h1><p>Pagina non trovata.</p></div>";
            $this->view('layouts/footer');
            return;
        }

        // Increment visits
        $diseaseModel->incrementVisits($malattia['id']);

        // In both controllers, ensure the connection is passed:
        $db = new Database();
        $conn = $db->connect();

        $this->view('layouts/header', [
            'page' => 'malattia',
            'conn' => $conn,  // Pass the connection here
            'currentDiseaseId' => $malattia['id'] ?? null
        ]);
        
        $this->view('malattia', ['malattia' => $malattia]);
        
        $this->view('layouts/footer');
    }
}
?>