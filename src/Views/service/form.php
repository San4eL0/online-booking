<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-<?= $service ? 'edit' : 'plus' ?>"></i> <?= $service ? 'Редактирование услуги' : 'Добавление услуги' ?></h1>
    <a href="index.php?entity=service&action=list" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад к списку
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger"><?= escape($errors['general']) ?></div>
        <?php endif; ?>
        
        <form method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="csrf_token" value="<?= escape($csrf_token) ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Название услуги <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                       id="name" name="name" required
                       value="<?= escape($service->name ?? '') ?>">
                <?php if (isset($errors['name'])): ?>
                    <div class="invalid-feedback"><?= escape($errors['name']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= escape($service->description ?? '') ?></textarea>
                <small class="text-muted">Подробное описание услуги (не обязательно)</small>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Цена (₽) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" 
                           id="price" name="price" required
                           value="<?= escape($service->price ?? '') ?>">
                    <?php if (isset($errors['price'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['price']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="duration_minutes" class="form-label">Длительность (минуты) <span class="text-danger">*</span></label>
                    <input type="number" min="1" class="form-control <?= isset($errors['duration_minutes']) ? 'is-invalid' : '' ?>" 
                           id="duration_minutes" name="duration_minutes" required
                           value="<?= escape($service->duration_minutes ?? '') ?>">
                    <?php if (isset($errors['duration_minutes'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['duration_minutes']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                           <?= (!isset($service) || $service->is_active) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">
                        Услуга активна (доступна для записи)
                    </label>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?= $service ? 'Сохранить изменения' : 'Создать' ?>
                </button>
            </div>
        </form>
    </div>
</div>
