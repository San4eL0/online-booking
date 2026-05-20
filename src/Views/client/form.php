<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-<?= $client ? 'edit' : 'plus' ?>"></i> <?= $client ? 'Редактирование клиента' : 'Добавление клиента' ?></h1>
    <a href="index.php?entity=client&action=list" class="btn btn-secondary">
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
                           value="<?= escape($client->last_name ?? '') ?>">
                    <?php if (isset($errors['last_name'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['last_name']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="first_name" class="form-label">Имя <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                           id="first_name" name="first_name" required
                           value="<?= escape($client->first_name ?? '') ?>">
                    <?php if (isset($errors['first_name'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['first_name']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="middle_name" class="form-label">Отчество</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                           value="<?= escape($client->middle_name ?? '') ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" 
                           id="phone" name="phone" required
                           value="<?= escape($client->phone ?? '') ?>"
                           pattern="^\+?[0-9\s\-\(\)]{10,}$" title="Введите корректный номер телефона">
                    <?php if (isset($errors['phone'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['phone']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                           id="email" name="email"
                           value="<?= escape($client->email ?? '') ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= escape($errors['email']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="birth_date" class="form-label">Дата рождения</label>
                <input type="date" class="form-control <?= isset($errors['birth_date']) ? 'is-invalid' : '' ?>" 
                       id="birth_date" name="birth_date"
                       value="<?= escape($client->birth_date ?? '') ?>"
                       max="<?= date('Y-m-d') ?>">
                    <small class="text-muted">Формат: ГГГГ-ММ-ДД</small>
                <?php if (isset($errors['birth_date'])): ?>
                    <div class="invalid-feedback"><?= escape($errors['birth_date']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?= $client ? 'Сохранить изменения' : 'Создать' ?>
                </button>
            </div>
        </form>
    </div>
</div>
