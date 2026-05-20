<?php
// src/Controllers/SpecialistController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Repositories/SpecialistRepository.php';

class SpecialistController extends BaseController {
    private $specialistRepo;
    
    public function __construct() {
        $this->entity = 'specialist';
        $this->title = 'Специалисты';
        $this->specialistRepo = new SpecialistRepository();
    }
    
    public function list() {
        $params = $this->getPageParams();
        
        if ($params['search']) {
            $specialists = $this->specialistRepo->search($params['search'], $params['sort'], $params['order'], $params['perPage'], $params['offset']);
            $total = $this->specialistRepo->getSearchCount($params['search']);
        } else {
            $specialists = $this->specialistRepo->findAll($params['sort'], $params['order'], $params['perPage'], $params['offset']);
            $total = $this->specialistRepo->getCount();
        }
        
        $totalPages = ceil($total / $params['perPage']);
        
        $this->render('list', [
            'specialists' => $specialists,
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
                redirect('index.php?action=list&entity=specialist', 'Неверный CSRF токен', 'error');
            }
            
            $errors = $this->validate($_POST);
            
            if (empty($errors)) {
                $data = [
                    'last_name' => $_POST['last_name'],
                    'first_name' => $_POST['first_name'],
                    'middle_name' => $_POST['middle_name'] ?? null,
                    'specialization' => $_POST['specialization'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'] ?? null,
                    'hire_date' => $_POST['hire_date'] ?? null,
                    'is_active' => isset($_POST['is_active']) ? 1 : 0
                ];
                
                if ($this->specialistRepo->create($data)) {
                    redirect('index.php?action=list&entity=specialist', 'Специалист успешно добавлен', 'success');
                } else {
                    $errors['general'] = 'Ошибка при добавлении специалиста';
                }
            }
        }
        
        $this->render('form', [
            'specialist' => null,
            'errors' => $errors ?? [],
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function edit() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=specialist', 'Неверный ID специалиста', 'error');
        }
        
        $specialist = $this->specialistRepo->findById($id);
        if (!$specialist) {
            redirect('index.php?action=list&entity=specialist', 'Специалист не найден', 'error');
        }
        
        if ($this->isPost()) {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                redirect('index.php?action=list&entity=specialist', 'Неверный CSRF токен', 'error');
            }
            
            $errors = $this->validate($_POST);
            
            if (empty($errors)) {
                $data = [
                    'last_name' => $_POST['last_name'],
                    'first_name' => $_POST['first_name'],
                    'middle_name' => $_POST['middle_name'] ?? null,
                    'specialization' => $_POST['specialization'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'] ?? null,
                    'hire_date' => $_POST['hire_date'] ?? null,
                    'is_active' => isset($_POST['is_active']) ? 1 : 0
                ];
                
                if ($this->specialistRepo->update($id, $data)) {
                    redirect('index.php?action=list&entity=specialist', 'Специалист успешно обновлен', 'success');
                } else {
                    $errors['general'] = 'Ошибка при обновлении специалиста';
                }
            }
        }
        
        $this->render('form', [
            'specialist' => $specialist,
            'errors' => $errors ?? [],
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function delete() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=specialist', 'Неверный ID специалиста', 'error');
        }
        
        $specialist = $this->specialistRepo->findById($id);
        if (!$specialist) {
            redirect('index.php?action=list&entity=specialist', 'Специалист не найден', 'error');
        }
        
        if ($this->isPost()) {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                redirect('index.php?action=list&entity=specialist', 'Неверный CSRF токен', 'error');
            }
            
            if ($this->specialistRepo->hasAppointments($id)) {
                $this->render('delete', [
                    'specialist' => $specialist,
                    'error' => 'Невозможно удалить специалиста, у которого есть будущие записи',
                    'csrf_token' => generateCsrfToken()
                ]);
                return;
            }
            
            if ($this->specialistRepo->delete($id)) {
                redirect('index.php?action=list&entity=specialist', 'Специалист успешно удален', 'success');
            } else {
                $this->render('delete', [
                    'specialist' => $specialist,
                    'error' => 'Ошибка при удалении специалиста',
                    'csrf_token' => generateCsrfToken()
                ]);
                return;
            }
        }
        
        $this->render('delete', [
            'specialist' => $specialist,
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function view() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=specialist', 'Неверный ID специалиста', 'error');
        }
        
        $specialist = $this->specialistRepo->findById($id);
        if (!$specialist) {
            redirect('index.php?action=list&entity=specialist', 'Специалист не найден', 'error');
        }
        
        $this->render('view', [
            'specialist' => $specialist
        ]);
    }
    
    private function validate($data) {
        $errors = [];
        
        validateRequired('last_name', $data['last_name'] ?? '', $errors, 'Фамилия');
        validateRequired('first_name', $data['first_name'] ?? '', $errors, 'Имя');
        validateRequired('specialization', $data['specialization'] ?? '', $errors, 'Специализация');
        validatePhone($data['phone'] ?? '', $errors);
        validateEmail($data['email'] ?? '', $errors);
        
        if (!empty($data['hire_date'])) {
            $hireDate = strtotime($data['hire_date']);
            if ($hireDate > time()) {
                $errors['hire_date'] = "Дата приема не может быть в будущем";
            }
        }
        
        return $errors;
    }
}
