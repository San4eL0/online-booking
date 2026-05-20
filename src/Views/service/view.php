<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-info-circle"></i> Просмотр услуги</h1>
    <div>
        <a href="index.php?entity=service&action=edit&id=<?= $service->id ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Редактировать
        </a>
        <a href="index.php?entity=service&action=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад к списку
        </a>
    </div>
</div>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?entity=service&action=list">Услуги</a></li>
        <li class="breadcrumb-item active" aria-current="page">Просмотр услуги</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><?= escape($service->name) ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">ID:</th>
                        <td><?= escape($service->id) ?></td>
                    </tr>
                    <tr>
                        <th>Название:</th>
                        <td><strong><?= escape($service->name) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Описание:</th>
                        <td><?= escape($service->description ?? '—') ?></td>
                    </tr>
                    <tr>
                        <th>Цена:</th>
                        <td><span class="h4 text-primary"><?= $service->getFormattedPrice() ?></span></td>
                    </tr>
                    <tr>
                        <th>Длительность:</th>
                        <td><?= $service->getFormattedDuration() ?></td>
                    </tr>
                    <tr>
                        <th>Статус:</th>
                        <td><?= $service->getStatusBadge() ?></td>
                    </tr>
                    <tr>
                        <th>Дата создания:</th>
                        <td><?= date('d.m.Y H:i', strtotime($service->created_at)) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
