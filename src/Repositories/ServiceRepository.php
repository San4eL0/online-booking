<?php
// src/Repositories/ServiceRepository.php
require_once __DIR__ . '/../Models/Service.php';
require_once __DIR__ . '/../../config/database.php';

class ServiceRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }
    
    public function findAll($sort = 'id', $order = 'ASC', $limit = 10, $offset = 0) {
        $allowedSorts = ['id', 'name', 'price', 'duration_minutes', 'is_active', 'created_at'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM services ORDER BY $sort $order LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Service');
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM services WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Service');
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO services (name, description, price, duration_minutes, is_active) 
                VALUES (:name, :description, :price, :duration_minutes, :is_active)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':price' => $data['price'],
            ':duration_minutes' => $data['duration_minutes'],
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE services SET name = :name, description = :description, 
                price = :price, duration_minutes = :duration_minutes, is_active = :is_active 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':price' => $data['price'],
            ':duration_minutes' => $data['duration_minutes'],
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM services WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public function getCount() {
        $sql = "SELECT COUNT(*) FROM services";
        return (int)$this->pdo->query($sql)->fetchColumn();
    }
    
    public function search($term, $sort = 'id', $order = 'ASC', $limit = 10, $offset = 0) {
        $allowedSorts = ['id', 'name', 'price', 'duration_minutes'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM services WHERE name LIKE :term OR description LIKE :term 
                ORDER BY $sort $order LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':term', "%$term%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Service');
    }
    
    public function getSearchCount($term) {
        $sql = "SELECT COUNT(*) FROM services WHERE name LIKE :term OR description LIKE :term";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':term' => "%$term%"]);
        return (int)$stmt->fetchColumn();
    }
    
    public function hasAppointments($serviceId) {
        $sql = "SELECT COUNT(*) FROM appointments WHERE service_id = :service_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':service_id' => $serviceId]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
