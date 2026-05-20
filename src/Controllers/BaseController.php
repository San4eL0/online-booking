<?php
abstract class BaseController {
    protected $pdo;
    protected $repository;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Общий метод для рендера вьюх
    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../Views/layout/header.php";
        require_once __DIR__ . "/../Views/{$view}.php";
        require_once __DIR__ . "/../Views/layout/footer.php";
    }
    
    // Перенаправление с flash-сообщением
    protected function redirect($url, $message = '', $type = 'success') {
        if ($message) {
            $_SESSION['flash'] = ['message' => $message, 'type' => $type];
        }
        header("Location: $url");
        exit;
    }
    
    // Получение flash-сообщения (вызывать в header.php)
    public static function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}
