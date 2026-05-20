<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape($title ?? 'Система онлайн-записи') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php?entity=client&action=list">
                <i class="fas fa-calendar-check"></i> Онлайн-запись
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= ($entity ?? '') === 'client' ? 'active' : '' ?>" 
                           href="index.php?entity=client&action=list">
                            <i class="fas fa-users"></i> Клиенты
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($entity ?? '') === 'service' ? 'active' : '' ?>" 
                           href="index.php?entity=service&action=list">
                            <i class="fas fa-concierge-bell"></i> Услуги
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($entity ?? '') === 'specialist' ? 'active' : '' ?>" 
                           href="index.php?entity=specialist&action=list">
                            <i class="fas fa-user-md"></i> Специалисты
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="container my-4">
        <?php if ($flash = getFlashMessage()): ?>
            <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?= $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
                <?= escape($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
