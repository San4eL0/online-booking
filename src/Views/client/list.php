<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-users"></i> Клиенты</h1>
    <a href="index.php?entity=client&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Добавить клиента
    </a>
</div>

<!-- Поиск -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="entity" value="client">
            <input type="hidden" name="action" value="list">
            <?php if (isset($sort) && isset($order)): ?>
                <input type="hidden" name="sort" value="<?= escape($sort) ?>">
                <input type="hidden" name="order" value="<?= escape($order) ?>">
            <?php endif; ?>
            <div class="col-md-9">
                <input type="text" name="search" class="form-control" 
                       placeholder="Поиск по фамилии, имени или телефону..." 
                       value="<?= escape($search) ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Найти
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Таблица клиентов -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'id', 'order' => ($sort == 'id' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">ID</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'last_name', 'order' => ($sort == 'last_name' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Фамилия</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'first_name', 'order' => ($sort == 'first_name' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Имя</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'phone', 'order' => ($sort == 'phone' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Телефон</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'email', 'order' => ($sort == 'email' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Email</a></th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clients)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Клиенты не найдены
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= escape($client->id) ?></td>
                        <td><?= escape($client->last_name) ?></td>
                        <td><?= escape($client->first_name) ?></td>
                        <td><?= escape($client->phone) ?></td>
                        <td><?= escape($client->email ?? '—') ?></td>
                        <td class="text-nowrap">
                            <a href="index.php?entity=client&action=view&id=<?= $client->id ?>" class="btn btn-sm btn-info" title="Просмотр">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="index.php?entity=client&action=edit&id=<?= $client->id ?>" class="btn btn-sm btn-warning" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?entity=client&action=delete&id=<?= $client->id ?>" class="btn btn-sm btn-danger" title="Удалить">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Пагинация -->
<?php if ($totalPages > 1): ?>
<nav>
    <ul class="pagination justify-content-center">
        <?php if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage - 1])) ?>">
                    <i class="fas fa-chevron-left"></i> Назад
                </a>
            </li>
        <?php endif; ?>
        
        <?php 
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);
        ?>
        
        <?php if ($startPage > 1): ?>
            <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">1</a></li>
            <?php if ($startPage > 2): ?>
                <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        
        <?php if ($endPage < $totalPages): ?>
            <?php if ($endPage < $totalPages - 1): ?>
                <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
            <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>"><?= $totalPages ?></a></li>
        <?php endif; ?>
        
        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) ?>">
                    Вперед <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>
