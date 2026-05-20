<!DOCTYPE html>
<html>
<head>
    <title>Онлайн-запись</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php $flash = BaseController::getFlash(); ?>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>
