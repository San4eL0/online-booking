<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user-circle"></i> Просмотр клиента</h1>
    <div>
        <a href="index.php?entity=client&action=edit&id=<?= $client->id ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Редактировать
        </a>
        <a href="index.php?entity=client&action=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад к списку
        </a>
    </div>
</div>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?entity=client&action=list">Клиенты</a></li>
        <li class="breadcrumb-item active" aria-current="page">Просмотр клиента</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Основная информация</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">ID:</th>
                        <td><?= escape($client->id) ?></td>
                    </tr>
                    <tr>
                        <th>Фамилия:</th>
                        <td><?= escape($client->last_name) ?></td>
                    </tr>
                    <tr>
                        <th>Имя:</th>
                        <td><?= escape($client->first_name) ?></td>
                    </tr>
                    <tr>
                        <th>Отчество:</th>
                        <td><?= escape($client->middle_name ?? '—') ?></td>
                    </tr>
                    <tr>
                        <th>Полное имя:</th>
                        <td><strong><?= escape($client->getFullName()) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Телефон:</th>
                        <td><?= escape($client->phone) ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?= escape($client->email ?? '—') ?></td>
                    </tr>
                    <tr>
                        <th>Дата рождения:</th>
                        <td><?= $client->getFormattedBirthDate() ?></td>
                    </tr>
                    <tr>
                        <th>Возраст:</th>
                        <td><?= $client->getAge() ? escape($client->getAge()) . ' лет' : '—' ?></td>
                    </tr>
                    <tr>
                        <th>Дата регистрации:</th>
                        <td><?= date('d.m.Y H:i', strtotime($client->created_at)) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Статистика записей</h5>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <div class="display-4 text-primary"><?= $appointmentsCount ?></div>
                    <p class="text-muted">всего записей на прием</p>
                </div>
                <?php if ($appointmentsCount > 0): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        У клиента есть записи. При удалении клиента все его записи также будут удалены.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
