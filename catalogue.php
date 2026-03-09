<?php
$pageTitle = 'Catalogue';
$rootPath  = '';
require_once 'include/connexion.php';
include 'include/header.php';
include 'include/menu.php';

// Pour chaque voiture : est-elle louée aujourd'hui ? Quand sera-t-elle libre ?
$stmt = mysqli_prepare($connexion, "
    SELECT
        v.*,
        EXISTS (
            SELECT 1 FROM locations l
            WHERE l.id_voiture = v.id
              AND l.date_debut <= CURDATE()
              AND l.date_fin   >  CURDATE()
        ) AS louee_aujourd_hui,
        (
            SELECT MIN(l2.date_fin)
            FROM locations l2
            WHERE l2.id_voiture = v.id
              AND l2.date_debut <= CURDATE()
              AND l2.date_fin   >  CURDATE()
        ) AS libre_le
    FROM voitures v
    ORDER BY v.marque, v.modele
");
mysqli_stmt_execute($stmt);
$voitures = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

$message = $_GET['message'] ?? null;
?>

<main class="catalogue-wrapper">
    <div class="container">

        <h1 class="page-title reveal">Notre Catalogue</h1>

        <?php if ($message === 'location_ok'): ?>
            <div class="alert alert-success">✓ &nbsp;Votre location a bien été enregistrée.</div>
        <?php elseif ($message === 'conflit'): ?>
            <div class="alert alert-error">✕ &nbsp;Ce véhicule est déjà réservé sur ces dates. Choisissez une autre période.</div>
        <?php elseif ($message === 'erreur'): ?>
            <div class="alert alert-error">✕ &nbsp;Une erreur est survenue. Veuillez réessayer.</div>
        <?php endif; ?>

        <div class="cars-grid">
            <?php foreach ($voitures as $i => $v):
                $louee = (bool)$v['louee_aujourd_hui'];
            ?>
                <div class="car-card reveal <?= $louee ? 'car-unavailable' : '' ?>"
                     style="transition-delay:<?= ($i % 3) * .1 ?>s">

                    <div class="car-image">
                        <img src="<?= e($v['image_path']) ?>"
                             alt="<?= e($v['marque'] . ' ' . $v['modele']) ?>"
                             loading="lazy"
                             onerror="this.src='img/default.jpg'">
                        <span class="car-badge <?= $louee ? 'badge-rented' : 'badge-available' ?>">
                            <?= $louee ? 'Indisponible' : 'Disponible' ?>
                        </span>
                    </div>

                    <div class="car-info">
                        <p class="car-meta"><?= e($v['annee']) ?> &mdash; <?= e($v['marque']) ?></p>
                        <h3><?= e($v['modele']) ?></h3>
                        <p class="car-price">
                            <?= number_format($v['prix_jour'], 2, ',', '&nbsp;') ?> €<span>/ jour</span>
                        </p>

                        <?php if ($louee && $v['libre_le']): ?>
                            <p class="disponible-le">
                                Disponible à partir du
                                <strong><?= date('d/m/Y', strtotime($v['libre_le'])) ?></strong>
                            </p>
                        <?php endif; ?>

                        <?php if (!$louee): ?>
                            <?php if (isLoggedIn()): ?>
                                <form action="louer.php" method="POST" class="rent-form">
                                    <input type="hidden" name="id_voiture" value="<?= (int)$v['id'] ?>">
                                    <div class="date-row">
                                        <input type="date" name="date_debut" required
                                               min="<?= date('Y-m-d') ?>">
                                        <input type="date" name="date_fin" required
                                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Réserver</button>
                                </form>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline">Connexion pour réserver</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="btn btn-disabled" disabled>Indisponible actuellement</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php include 'include/footer.php'; ?>
