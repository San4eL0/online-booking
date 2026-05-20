<?php
// src/Repositories/SpecialistRepository.php
require_once __DIR__ . '/../Models/Specialist.php';
require_once __DIR__ . '/../../config/database.php';

class SpecialistRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }
    
    public function findAll($sort = 'id', $order = 'ASC', $limit = 10, $offset = 0) {
        $allowedSorts = ['id', 'last_name', 'first_name', 'specialization', 'phone', 'email', 'hire_date', 'is_active'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM specialists ORDER BY $sort $order LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Specialist');
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM specialists WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Specialist');
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO specialists (last_name, first_name, middle_name, specialization, phone, email, hire_date, is_active) 
                VALUES (:last_name, :first_name, :middle_name, :specialization, :phone, :email, :hire_date, :is_active)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':last_name' => $data['last_name'],
            ':first_name' => $data['first_name'],
            ':middle_name' => $data['middle_name'] ?? null,
            ':specialization' => $data['specialization'],
            ':phone' => $data['phone'],
            ':email' => $data['email'] ?? null,
            ':hire_date' => $data['hire_date'] ?? null,
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE specialists SET last_name = :last_name, first_name = :first_name, 
                middle_name = :middle_name, specialization = :specialization, phone = :phone, 
                email = :email, hire_date = :hire_date, is_active = :is_active 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':last_name' => $data['last_name'],
            ':first_name' => $data['first_name'],
            ':middle_name' => $data['middle_name'] ?? null,
            ':specialization' => $data['specialization'],
            ':phone' => $data['phone'],
            ':email' => $data['email'] ?? null,
            ':hire_date' => $data['hire_date'] ?? null,
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM specialists WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public function getCount() {
        $sql = "SELECT COUNT(*) FROM specialists";
        return (int)$this->pdo->query($sql)->fetchColumn();
    }
    
    public function search($term, $sort = 'id', $order = 'ASC', $limit = 10, $offset = 0) {
        $allowedSorts = ['id', 'last_name', 'first_name', 'specialization', 'phone'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM specialists WHERE last_name LIKE :term OR first_name LIKE :term OR specialization LIKE :term 
                ORDER BY $sort $order LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':term', "%$term%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Specialist');
    }
    
    public function getSearchCount($term) {
        $sql = "SELECT COUNT(*) FROM specialists WHERE last_name LIKE :term OR first_name LIKE :term OR specialization LIKE :term";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':term' => "%$term%"]);
        return (int)$stmt->fetchColumn();
    }
    
    public function hasAppointments($specialistId) {
        $sql = "SELECT COUNT(*) FROM appointments WHERE specialist_id = :specialist_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':specialist_id' => $specialistId]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
