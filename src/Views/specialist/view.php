<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-id-card"></i> Просмотр специалиста</h1>
    <div>
        <a href="index.php?entity=specialist&action=edit&id=<?= $specialist->id ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Редактировать
        </a>
        <a href="index.php?entity=specialist&action=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад к списку
        </a>
    </div>
</div>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?entity=specialist&action=list">Специалисты</a></li>
        <li class="breadcrumb-item active" aria-current="page">Просмотр специалиста</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><?= escape($specialist->getFullName()) ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">ID:</th>
                        <td><?= escape($specialist->id) ?></td>
                    </tr>
                    <tr>
                        <th>Фамилия:</th>
                        <td><?= escape($specialist->last_name) ?></td>
                    </tr>
                    <tr>
                        <th>Имя:</th>
                        <td><?= escape($specialist->first_name) ?></td>
                    </tr>
                    <tr>
                        <th>Отчество:</th>
                        <td><?= escape($specialist->middle_name ?? '—') ?></td>
                    </tr>
                    <tr>
                        <th>Полное имя:</th>
                        <td><strong><?= escape($specialist->getFullName()) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Специализация:</th>
                        <td><?= escape($specialist->specialization) ?></td>
                    </tr>
                    <tr>
                        <th>Телефон:</th>
                        <td><?= escape($specialist->phone) ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?= escape($specialist->email ?? '—') ?></td>
                    </tr>
                    <tr>
                        <th>Дата приема:</th>
                        <td><?= $specialist->hire_date ? date('d.m.Y', strtotime($specialist->hire_date)) : '—' ?></td>
                    </tr>
                    <tr>
                        <th>Стаж работы:</th>
                        <td><?= $specialist->getExperience() ?></td>
                    </tr>
                    <tr>
                        <th>Статус:</th>
                        <td><?= $specialist->getStatusBadge() ?></td>
                    </tr>
                    <tr>
                        <th>Дата регистрации:</th>
                        <td><?= date('d.m.Y H:i', strtotime($specialist->created_at)) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
