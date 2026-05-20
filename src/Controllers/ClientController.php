<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Repositories/ClientRepository.php';

class ClientController extends BaseController {
    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->repository = new ClientRepository($pdo);
    }
    
    // Список с пагинацией и сортировкой
    public function list() {
        $page = $_GET['page'] ?? 1;
        $sort = $_GET['sort'] ?? 'id';
        $direction = $_GET['dir'] ?? 'ASC';
        
        $perPage = 10;
        $clients = $this->repository->getPaginated($page, $perPage, $sort, $direction);
        $total = $this->repository->count();
        $totalPages = ceil($total / $perPage);
        
        $this->render('client/index', [
            'clients' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }
    
    // Форма создания
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validate($_POST);
            if (empty($errors)) {
                $this->repository->create($_POST);
                $this->redirect('index.php?entity=client&action=list', 'Клиент добавлен');
            } else {
                $this->render('client/create', ['errors' => $errors, 'old' => $_POST]);
            }
        } else {
            $this->render('client/create');
        }
    }
    
    // Форма редактирования
    public function edit($id) {
        $client = $this->repository->findById($id);
        if (!$client) {
            $this->redirect('index.php?entity=client&action=list', 'Клиент не найден', 'error');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validate($_POST);
            if (empty($errors)) {
                $this->repository->update($id, $_POST);
                $this->redirect('index.php?entity=client&action=list', 'Клиент обновлён');
            } else {
                $this->render('client/edit', ['client' => $client, 'errors' => $errors, 'old' => $_POST]);
            }
        } else {
            $this->render('client/edit', ['client' => $client]);
        }
    }
    
    // Удаление с проверкой связей
    public function delete($id) {
        $client = $this->repository->findById($id);
        if (!$client) {
            $this->redirect('index.php?entity=client&action=list', 'Клиент не найден', 'error');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Проверка: есть ли у клиента записи
            $hasAppointments = $this->repository->hasFutureAppointments($id);
            if ($hasAppointments) {
                $this->render('client/delete', [
                    'client' => $client,
                    'error' => 'Нельзя удалить клиента с будущими записями'
                ]);
                return;
            }
            
            $this->repository->delete($id);
            $this->redirect('index.php?entity=client&action=list', 'Клиент удалён');
        } else {
            $this->render('client/delete', ['client' => $client]);
        }
    }
    
    // Просмотр деталей (для pull request)
    public function view($id) {
        $client = $this->repository->findById($id);
        $appointments = $this->repository->getAppointments($id);
        $this->render('client/view', ['client' => $client, 'appointments' => $appointments]);
    }
    
    // Валидация
    private function validate($data) {
        $errors = [];
        if (empty($data['last_name'])) $errors['last_name'] = 'Фамилия обязательна';
        if (empty($data['first_name'])) $errors['first_name'] = 'Имя обязательно';
        if (!empty($data['phone']) && !preg_match('/^\+?\d{10,15}$/', $data['phone'])) {
            $errors['phone'] = 'Неверный формат телефона';
        }
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Неверный email';
        }
        return $errors;
    }
}
