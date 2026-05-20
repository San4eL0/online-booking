<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-trash-alt text-danger"></i> Удаление услуги</h1>
    <a href="index.php?entity=service&action=list" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад к списку
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> <?= escape($error) ?>
            </div>
            <div class="text-end">
                <a href="index.php?entity=service&action=list" class="btn btn-primary">Вернуться к списку</a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> 
                Вы действительно хотите удалить услугу <strong><?= escape($service->name) ?></strong>?
                <br><small class="text-muted">Это действие необратимо.</small>
            </div>
            
            <div class="card mb-3">
                <div class="card-body">
                    <h6>Информация об услуге:</h6>
                    <p class="mb-1"><strong>Цена:</strong> <?= $service->getFormattedPrice() ?></p>
                    <p class="mb-1"><strong>Длительность:</strong> <?= $service->getFormattedDuration() ?></p>
                    <p class="mb-0"><strong>Статус:</strong> <?= $service->is_active ? 'Активна' : 'Неактивна' ?></p>
                </div>
            </div>
            
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= escape($csrf_token) ?>">
                <div class="text-end">
                    <a href="index.php?entity=service&action=list" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Подтвердить удаление
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
