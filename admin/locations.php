<?php
$pageTitle = 'Suivi des locations';
$rootPath  = '../';
require_once '../include/connexion.php';
requireAdmin('../index.php');
include '../include/header.php';
include '../include/menu.php';

// Récupère toutes les locations avec les infos du client et de la voiture
$stmt = mysqli_prepare($connexion, "
    SELECT
        l.id,
        l.date_debut,
        l.date_fin,
        l.created_at,
        DATEDIFF(l.date_fin, l.date_debut)          AS nb_jours,
        DATEDIFF(l.date_fin, l.date_debut)
            * v.prix_jour                           AS total,
        u.nom, u.prenom, u.email,
        v.marque, v.modele, v.annee, v.image_path, v.statut
    FROM Locations l
    JOIN Utilisateurs u ON u.id = l.id_utilisateur
    JOIN Voitures     v ON v.id = l.id_voiture
    ORDER BY l.created_at DESC
");
mysqli_stmt_execute($stmt);
$locations = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// KPIs
$total_locations = count($locations);
$revenu_total    = array_sum(array_column($locations, 'total'));

$stmt2 = mysqli_prepare($connexion, "SELECT COUNT(*) FROM Voitures WHERE statut = 'louee'");
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $voitures_louees);
mysqli_stmt_fetch($stmt2);
mysqli_stmt_close($stmt2);
?>

<main class="container">

    <div class="admin-header">
        <h1 class="page-title" style="margin-bottom:0;padding-bottom:0;">
            <span style="color:var(--grey-3);display:block;letter-spacing:.15em;font-family:var(--font-ui);font-size:.75rem;margin-bottom:.5rem;">ADMINISTRATION</span>
            Suivi des locations
        </h1>
        <a href="index.php" class="btn btn-outline">← Voitures</a>
    </div>

    <!-- KPIs -->
    <div class="kpi-grid">
        <div class="kpi-card reveal">
            <div class="kpi-value"><?= $total_locations ?></div>
            <div class="kpi-label">Locations totales</div>
        </div>
        <div class="kpi-card reveal reveal-delay-1">
            <div class="kpi-value"><?= $voitures_louees ?></div>
            <div class="kpi-label">Voitures actuellement louées</div>
        </div>
        <div class="kpi-card reveal reveal-delay-2">
            <div class="kpi-value"><?= number_format($revenu_total, 0, ',', ' ') ?> €</div>
            <div class="kpi-label">Revenu total estimé</div>
        </div>
    </div>

    <!-- Table -->
    <?php if (empty($locations)): ?>
        <p style="color:var(--grey-3);text-align:center;padding:4rem 0;font-size:.9rem;letter-spacing:.06em;">
            Aucune location enregistrée pour le moment.
        </p>
    <?php else: ?>
    <div class="table-wrapper reveal">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Véhicule</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Du</th>
                    <th>Au</th>
                    <th>Durée</th>
                    <th>Total estimé</th>
                    <th>Réservé le</th>
                    <th>Statut véhicule</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locations as $l): ?>
                <tr>
                    <td style="color:var(--grey-3)"><?= $l['id'] ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <?php
                                $src = (str_starts_with($l['image_path'], 'http'))
                                    ? e($l['image_path'])
                                    : '../' . e($l['image_path']);
                            ?>
                            <img src="<?= $src ?>"
                                 alt=""
                                 class="admin-thumb"
                                 onerror="this.src='../img/default.jpg'">
                            <div>
                                <div style="color:var(--white);font-weight:500;"><?= e($l['marque']) ?> <?= e($l['modele']) ?></div>
                                <div style="color:var(--grey-3);font-size:.75rem;letter-spacing:.06em;"><?= e($l['annee']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--white)"><?= e($l['prenom']) ?> <?= e($l['nom']) ?></td>
                    <td style="color:var(--grey-4);font-size:.82rem;"><?= e($l['email']) ?></td>
                    <td><?= date('d/m/Y', strtotime($l['date_debut'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($l['date_fin'])) ?></td>
                    <td>
                        <span style="color:var(--gold)"><?= $l['nb_jours'] ?></span>
                        <span style="color:var(--grey-3);font-size:.8rem;"> jour<?= $l['nb_jours'] > 1 ? 's' : '' ?></span>
                    </td>
                    <td style="color:var(--gold);font-weight:500;"><?= number_format($l['total'], 2, ',', ' ') ?> €</td>
                    <td style="color:var(--grey-3);font-size:.82rem;"><?= date('d/m/Y H:i', strtotime($l['created_at'])) ?></td>
                    <td>
                        <span class="car-badge <?= $l['statut'] === 'disponible' ? 'badge-available' : 'badge-rented' ?>">
                            <?= $l['statut'] ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</main>

<?php include '../include/footer.php'; ?>
