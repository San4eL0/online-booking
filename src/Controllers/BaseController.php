<?php
// src/Controllers/BaseController.php
abstract class BaseController {
    protected $entity;
    protected $title;
    
    protected function render($view, $data = []) {
        extract($data);
        $flash = getFlashMessage();
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/' . $this->entity . '/' . $view . '.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }
    
    protected function getPageParams() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
        $order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        return [
            'page' => $page,
            'perPage' => $perPage,
            'offset' => $offset,
            'sort' => $sort,
            'order' => $order,
            'search' => $search
        ];
    }
    
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function getId() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0 && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        return $id;
    }
}
