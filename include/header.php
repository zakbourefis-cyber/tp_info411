<?php require_once __DIR__ . '/fonctions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' — DriveNow' : 'DriveNow — Location Premium' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?= $rootPath ?? '' ?>css/site.css">
    <?php if (isset($extraCss)): ?>
        <link rel="stylesheet" href="<?= $rootPath ?? '' ?>css/<?= $extraCss ?>">
    <?php endif; ?>
</head>
<body>
