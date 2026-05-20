// Пагинация с сортировкой
public function getPaginated($page, $perPage, $sort = 'id', $direction = 'ASC') {
    $offset = ($page - 1) * $perPage;
    $sql = "SELECT * FROM clients ORDER BY $sort $direction LIMIT $perPage OFFSET $offset";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

public function count() {
    $stmt = $this->pdo->query("SELECT COUNT(*) FROM clients");
    return $stmt->fetchColumn();
}

// Проверка связей (если есть таблица appointments)
public function hasFutureAppointments($clientId) {
    $sql = "SELECT COUNT(*) FROM appointments 
            WHERE client_id = ? AND date >= CURDATE()";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$clientId]);
    return $stmt->fetchColumn() > 0;
}
