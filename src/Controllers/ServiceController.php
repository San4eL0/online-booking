<?php
// src/Controllers/ServiceController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Repositories/ServiceRepository.php';

class ServiceController extends BaseController {
    private $serviceRepo;
    
    public function __construct() {
        $this->entity = 'service';
        $this->title = 'Услуги';
        $this->serviceRepo = new ServiceRepository();
    }
    
    public function list() {
        $params = $this->getPageParams();
        
        if ($params['search']) {
            $services = $this->serviceRepo->search($params['search'], $params['sort'], $params['order'], $params['perPage'], $params['offset']);
            $total = $this->serviceRepo->getSearchCount($params['search']);
        } else {
            $services = $this->serviceRepo->findAll($params['sort'], $params['order'], $params['perPage'], $params['offset']);
            $total = $this->serviceRepo->getCount();
        }
        
        $totalPages = ceil($total / $params['perPage']);
        
        $this->render('list', [
            'services' => $services,
            'currentPage' => $params['page'],
            'totalPages' => $totalPages,
            'sort' => $params['sort'],
            'order' => strtolower($params['order']),
            'search' => $params['search']
        ]);
    }
    
    public function create() {
        if ($this->isPost()) {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                redirect('index.php?action=list&entity=service', 'Неверный CSRF токен', 'error');
            }
            
            $errors = $this->validate($_POST);
            
            if (empty($errors)) {
                $data = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'] ?? null,
                    'price' => $_POST['price'],
                    'duration_minutes' => $_POST['duration_minutes'],
                    'is_active' => isset($_POST['is_active']) ? 1 : 0
                ];
                
                if ($this->serviceRepo->create($data)) {
                    redirect('index.php?action=list&entity=service', 'Услуга успешно добавлена', 'success');
                } else {
                    $errors['general'] = 'Ошибка при добавлении услуги';
                }
            }
        }
        
        $this->render('form', [
            'service' => null,
            'errors' => $errors ?? [],
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function edit() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=service', 'Неверный ID услуги', 'error');
        }
        
        $service = $this->serviceRepo->findById($id);
        if (!$service) {
            redirect('index.php?action=list&entity=service', 'Услуга не найдена', 'error');
        }
        
        if ($this->isPost()) {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                redirect('index.php?action=list&entity=service', 'Неверный CSRF токен', 'error');
            }
            
            $errors = $this->validate($_POST);
            
            if (empty($errors)) {
                $data = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'] ?? null,
                    'price' => $_POST['price'],
                    'duration_minutes' => $_POST['duration_minutes'],
                    'is_active' => isset($_POST['is_active']) ? 1 : 0
                ];
                
                if ($this->serviceRepo->update($id, $data)) {
                    redirect('index.php?action=list&entity=service', 'Услуга успешно обновлена', 'success');
                } else {
                    $errors['general'] = 'Ошибка при обновлении услуги';
                }
            }
        }
        
        $this->render('form', [
            'service' => $service,
            'errors' => $errors ?? [],
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function delete() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=service', 'Неверный ID услуги', 'error');
        }
        
        $service = $this->serviceRepo->findById($id);
        if (!$service) {
            redirect('index.php?action=list&entity=service', 'Услуга не найдена', 'error');
        }
        
        if ($this->isPost()) {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                redirect('index.php?action=list&entity=service', 'Неверный CSRF токен', 'error');
            }
            
            if ($this->serviceRepo->hasAppointments($id)) {
                $this->render('delete', [
                    'service' => $service,
                    'error' => 'Невозможно удалить услугу, на которую есть записи',
                    'csrf_token' => generateCsrfToken()
                ]);
                return;
            }
            
            if ($this->serviceRepo->delete($id)) {
                redirect('index.php?action=list&entity=service', 'Услуга успешно удалена', 'success');
            } else {
                $this->render('delete', [
                    'service' => $service,
                    'error' => 'Ошибка при удалении услуги',
                    'csrf_token' => generateCsrfToken()
                ]);
                return;
            }
        }
        
        $this->render('delete', [
            'service' => $service,
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function view() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=service', 'Неверный ID услуги', 'error');
        }
        
        $service = $this->serviceRepo->findById($id);
        if (!$service) {
            redirect('index.php?action=list&entity=service', 'Услуга не найдена', 'error');
        }
        
        $this->render('view', [
            'service' => $service
        ]);
    }
    
    private function validate($data) {
        $errors = [];
        
        validateRequired('name', $data['name'] ?? '', $errors, 'Название услуги');
        
        if (isset($data['price'])) {
            $price = (float)$data['price'];
            if ($price < 0) {
                $errors['price'] = "Цена не может быть отрицательной";
            } elseif ($price == 0) {
                $errors['price'] = "Цена должна быть больше нуля";
            }
        }
        
        if (isset($data['duration_minutes'])) {
            $duration = (int)$data['duration_minutes'];
            if ($duration <= 0) {
                $errors['duration_minutes'] = "Длительность должна быть положительным числом";
            }
        }
        
        return $errors;
    }
}
