<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-<?= $specialist ? 'edit' : 'plus' ?>"></i> <?= $specialist ? 'Редактирование специалиста' : 'Добавление специалиста' ?></h1>
    <a href="index.php?entity=specialist&action=list" class="btn btn-secondary">
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
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="last_name" class="form-label">Фамилия <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>" 
                           id="last_name" name="last_name" required
                           value="<?= escape($specialist->last_name ?? '') ?>">
                    <?php if (isset($errors['last_name'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['last_name']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="first_name" class="form-label">Имя <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                           id="first_name" name="first_name" required
                           value="<?= escape($specialist->first_name ?? '') ?>">
                    <?php if (isset($errors['first_name'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['first_name']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="middle_name" class="form-label">Отчество</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                           value="<?= escape($specialist->middle_name ?? '') ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="specialization" class="form-label">Специализация <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= isset($errors['specialization']) ? 'is-invalid' : '' ?>" 
                       id="specialization" name="specialization" required
                       value="<?= escape($specialist->specialization ?? '') ?>">
                <?php if (isset($errors['specialization'])): ?>
                    <div class="invalid-feedback"><?= escape($errors['specialization']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" 
                           id="phone" name="phone" required
                           value="<?= escape($specialist->phone ?? '') ?>"
                           pattern="^\+?[0-9\s\-\(\)]{10,}$" title="Введите корректный номер телефона">
                    <?php if (isset($errors['phone'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['phone']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                           id="email" name="email"
                           value="<?= escape($specialist->email ?? '') ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['email']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="hire_date" class="form-label">Дата приема</label>
                    <input type="date" class="form-control <?= isset($errors['hire_date']) ? 'is-invalid' : '' ?>" 
                           id="hire_date" name="hire_date"
                           value="<?= escape($specialist->hire_date ?? '') ?>"
                           max="<?= date('Y-m-d') ?>">
                    <small class="text-muted">Формат: ГГГГ-ММ-ДД</small>
                    <?php if (isset($errors['hire_date'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['hire_date']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                               <?= (!isset($specialist) || $specialist->is_active) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">
                            Специалист работает
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?= $specialist ? 'Сохранить изменения' : 'Создать' ?>
                </button>
            </div>
        </form>
    </div>
</div>
