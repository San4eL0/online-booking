<div class="container">
    <h1>Клиенты</h1>
    
    <a href="index.php?entity=client&action=create" class="btn btn-primary">+ Добавить</a>
    
    <table class="table">
        <thead>
            <tr>
                <th><a href="?entity=client&sort=id&dir=<?= $direction === 'ASC' ? 'DESC' : 'ASC' ?>">ID</a></th>
                <th><a href="?entity=client&sort=last_name&dir=<?= $direction === 'ASC' ? 'DESC' 'ASC' ?>">Фамилия</a></th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['id']) ?></td>
                <td><?= htmlspecialchars($client['last_name']) ?></td>
                <td><?= htmlspecialchars($client['first_name']) ?></td>
                <td><?= htmlspecialchars($client['phone']) ?></td>
                <td>
                    <a href="?entity=client&action=view&id=<?= $client['id'] ?>">👁️</a>
                    <a href="?entity=client&action=edit&id=<?= $client['id'] ?>">✏️</a>
                    <a href="?entity=client&action=delete&id=<?= $client['id'] ?>" onclick="return confirm('Удалить?')">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Пагинация -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?entity=client&page=<?= $i ?>&sort=<?= $sort ?>&dir=<?= $direction ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
