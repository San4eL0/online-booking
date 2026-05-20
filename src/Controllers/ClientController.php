<?php
// src/Controllers/ClientController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Repositories/ClientRepository.php';

class ClientController extends BaseController {
    private $clientRepo;
    
    public function __construct() {
        $this->entity = 'client';
        $this->title = 'Клиенты';
        $this->clientRepo = new ClientRepository();
    }
    
    public function list() {
        $params = $this->getPageParams();
        
        if ($params['search']) {
            $clients = $this->clientRepo->search($params['search'], $params['sort'], $params['order'], $params['perPage'], $params['offset']);
            $total = $this->clientRepo->getSearchCount($params['search']);
        } else {
            $clients = $this->clientRepo->findAll($params['sort'], $params['order'], $params['perPage'], $params['offset']);
            $total = $this->clientRepo->getCount();
        }
        
        $totalPages = ceil($total / $params['perPage']);
        
        $this->render('list', [
            'clients' => $clients,
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
                redirect('index.php?action=list&entity=client', 'Неверный CSRF токен', 'error');
            }
            
            $errors = $this->validate($_POST);
            
            if (empty($errors)) {
                $data = [
                    'last_name' => $_POST['last_name'],
                    'first_name' => $_POST['first_name'],
                    'middle_name' => $_POST['middle_name'] ?? null,
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'] ?? null,
                    'birth_date' => $_POST['birth_date'] ?? null
                ];
                
                if ($this->clientRepo->create($data)) {
                    redirect('index.php?action=list&entity=client', 'Клиент успешно добавлен', 'success');
                } else {
                    $errors['general'] = 'Ошибка при добавлении клиента';
                }
            }
        }
        
        $this->render('form', [
            'client' => null,
            'errors' => $errors ?? [],
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function edit() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=client', 'Неверный ID клиента', 'error');
        }
        
        $client = $this->clientRepo->findById($id);
        if (!$client) {
            redirect('index.php?action=list&entity=client', 'Клиент не найден', 'error');
        }
        
        if ($this->isPost()) {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                redirect('index.php?action=list&entity=client', 'Неверный CSRF токен', 'error');
            }
            
            $errors = $this->validate($_POST);
            
            if (empty($errors)) {
                $data = [
                    'last_name' => $_POST['last_name'],
                    'first_name' => $_POST['first_name'],
                    'middle_name' => $_POST['middle_name'] ?? null,
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'] ?? null,
                    'birth_date' => $_POST['birth_date'] ?? null
                ];
                
                if ($this->clientRepo->update($id, $data)) {
                    redirect('index.php?action=list&entity=client', 'Клиент успешно обновлен', 'success');
                } else {
                    $errors['general'] = 'Ошибка при обновлении клиента';
                }
            }
        }
        
        $this->render('form', [
            'client' => $client,
            'errors' => $errors ?? [],
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function delete() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=client', 'Неверный ID клиента', 'error');
        }
        
        $client = $this->clientRepo->findById($id);
        if (!$client) {
            redirect('index.php?action=list&entity=client', 'Клиент не найден', 'error');
        }
        
        if ($this->isPost()) {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                redirect('index.php?action=list&entity=client', 'Неверный CSRF токен', 'error');
            }
            
            if ($this->clientRepo->hasAppointments($id)) {
                $this->render('delete', [
                    'client' => $client,
                    'error' => 'Невозможно удалить клиента, у которого есть записи на прием',
                    'csrf_token' => generateCsrfToken()
                ]);
                return;
            }
            
            if ($this->clientRepo->delete($id)) {
                redirect('index.php?action=list&entity=client', 'Клиент успешно удален', 'success');
            } else {
                $this->render('delete', [
                    'client' => $client,
                    'error' => 'Ошибка при удалении клиента',
                    'csrf_token' => generateCsrfToken()
                ]);
                return;
            }
        }
        
        $this->render('delete', [
            'client' => $client,
            'csrf_token' => generateCsrfToken()
        ]);
    }
    
    public function view() {
        $id = $this->getId();
        if ($id <= 0) {
            redirect('index.php?action=list&entity=client', 'Неверный ID клиента', 'error');
        }
        
        $client = $this->clientRepo->findById($id);
        if (!$client) {
            redirect('index.php?action=list&entity=client', 'Клиент не найден', 'error');
        }
        
        $appointmentsCount = $this->clientRepo->getAppointmentsCount($id);
        
        $this->render('view', [
            'client' => $client,
            'appointmentsCount' => $appointmentsCount
        ]);
    }
    
    private function validate($data) {
        $errors = [];
        
        validateRequired('last_name', $data['last_name'] ?? '', $errors, 'Фамилия');
        validateRequired('first_name', $data['first_name'] ?? '', $errors, 'Имя');
        validatePhone($data['phone'] ?? '', $errors);
        validateEmail($data['email'] ?? '', $errors);
        
        if (!empty($data['birth_date'])) {
            $birthDate = strtotime($data['birth_date']);
            if ($birthDate > time()) {
                $errors['birth_date'] = "Дата рождения не может быть в будущем";
            }
        }
        
        return $errors;
    }
}
