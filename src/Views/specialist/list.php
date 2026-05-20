<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user-md"></i> Специалисты</h1>
    <a href="index.php?entity=specialist&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Добавить специалиста
    </a>
</div>

<!-- Поиск -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="entity" value="specialist">
            <input type="hidden" name="action" value="list">
            <div class="col-md-9">
                <input type="text" name="search" class="form-control" 
                       placeholder="Поиск по фамилии, имени или специализации..." 
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

<!-- Таблица специалистов -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'id', 'order' => ($sort == 'id' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">ID</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'last_name', 'order' => ($sort == 'last_name' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Фамилия</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'first_name', 'order' => ($sort == 'first_name' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Имя</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'specialization', 'order' => ($sort == 'specialization' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Специализация</a></th>
                <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'phone', 'order' => ($sort == 'phone' && $order == 'asc') ? 'desc' : 'asc'])) ?>" class="text-white text-decoration-none">Телефон</a></th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($specialists)): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Специалисты не найдены
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($specialists as $specialist): ?>
                    <tr>
                        <td><?= escape($specialist->id) ?></td>
                        <td><?= escape($specialist->last_name) ?></td>
                        <td><?= escape($specialist->first_name) ?></td>
                        <td><?= escape($specialist->specialization) ?></td>
                        <td><?= escape($specialist->phone) ?></td>
                        <td><?= $specialist->getStatusBadge() ?></td>
                        <td class="text-nowrap">
                            <a href="index.php?entity=specialist&action=view&id=<?= $specialist->id ?>" class="btn btn-sm btn-info" title="Просмотр">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="index.php?entity=specialist&action=edit&id=<?= $specialist->id ?>" class="btn btn-sm btn-warning" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?entity=specialist&action=delete&id=<?= $specialist->id ?>" class="btn btn-sm btn-danger" title="Удалить">
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
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage - 1])) ?>">Назад</a>
            </li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        
        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) ?>">Вперед</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>
