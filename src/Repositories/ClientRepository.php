<?php
// src/Repositories/ClientRepository.php
require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../../config/database.php';

class ClientRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }
    
    public function findAll($sort = 'id', $order = 'ASC', $limit = 10, $offset = 0) {
        $allowedSorts = ['id', 'last_name', 'first_name', 'phone', 'email', 'birth_date', 'created_at'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM clients ORDER BY $sort $order LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Client');
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Client');
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO clients (last_name, first_name, middle_name, phone, email, birth_date) 
                VALUES (:last_name, :first_name, :middle_name, :phone, :email, :birth_date)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':last_name' => $data['last_name'],
            ':first_name' => $data['first_name'],
            ':middle_name' => $data['middle_name'] ?? null,
            ':phone' => $data['phone'],
            ':email' => $data['email'] ?? null,
            ':birth_date' => $data['birth_date'] ?? null
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE clients SET last_name = :last_name, first_name = :first_name, 
                middle_name = :middle_name, phone = :phone, email = :email, 
                birth_date = :birth_date WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data[':id'] = $id;
        return $stmt->execute([
            ':id' => $id,
            ':last_name' => $data['last_name'],
            ':first_name' => $data['first_name'],
            ':middle_name' => $data['middle_name'] ?? null,
            ':phone' => $data['phone'],
            ':email' => $data['email'] ?? null,
            ':birth_date' => $data['birth_date'] ?? null
        ]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM clients WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public function getCount() {
        $sql = "SELECT COUNT(*) FROM clients";
        return (int)$this->pdo->query($sql)->fetchColumn();
    }
    
    public function search($term, $sort = 'id', $order = 'ASC', $limit = 10, $offset = 0) {
        $allowedSorts = ['id', 'last_name', 'first_name', 'phone', 'email', 'birth_date'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM clients WHERE last_name LIKE :term OR first_name LIKE :term OR phone LIKE :term 
                ORDER BY $sort $order LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':term', "%$term%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Client');
    }
    
    public function getSearchCount($term) {
        $sql = "SELECT COUNT(*) FROM clients WHERE last_name LIKE :term OR first_name LIKE :term OR phone LIKE :term";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':term' => "%$term%"]);
        return (int)$stmt->fetchColumn();
    }
    
    public function hasAppointments($clientId) {
        $sql = "SELECT COUNT(*) FROM appointments WHERE client_id = :client_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':client_id' => $clientId]);
        return (int)$stmt->fetchColumn() > 0;
    }
    
    public function getAppointmentsCount($clientId) {
        $sql = "SELECT COUNT(*) FROM appointments WHERE client_id = :client_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':client_id' => $clientId]);
        return (int)$stmt->fetchColumn();
    }
}
