<nav class="navbar">
    <a class="navbar-brand" href="<?= $rootPath ?? '' ?>index.php">Drive<span class="brand-dot">.</span>Now</a>
    <ul class="navbar-links">
        <li><a href="<?= $rootPath ?? '' ?>index.php">Accueil</a></li>
        <li><a href="<?= $rootPath ?? '' ?>catalogue.php">Catalogue</a></li>
        <?php if (isLoggedIn()): ?>
            <li><a href="<?= $rootPath ?? '' ?>mes-locations.php">Mes locations</a></li>
        <?php endif; ?>
        <li><a href="<?= $rootPath ?? '' ?>contact.php">Contact</a></li>
    </ul>
    <ul class="navbar-auth">
        <?php if (isLoggedIn()): ?>
            <li class="user-hello"><?= e($_SESSION['prenom']) ?></li>
            <?php if (isAdmin()): ?>
                <li><a href="<?= $rootPath ?? '' ?>admin/index.php" class="btn btn-admin btn-sm">Admin</a></li>
            <?php endif; ?>
            <li><a href="<?= $rootPath ?? '' ?>logout.php" class="btn btn-outline btn-sm">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="<?= $rootPath ?? '' ?>login.php" class="btn btn-outline btn-sm">Connexion</a></li>
            <li><a href="<?= $rootPath ?? '' ?>register.php" class="btn btn-primary btn-sm">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>
