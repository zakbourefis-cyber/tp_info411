<?php
$pageTitle = 'Mes locations';
$rootPath  = '';
require_once 'include/connexion.php';
requireLogin('login.php');
include 'include/header.php';
include 'include/menu.php';

$id_user = (int)$_SESSION['user_id'];

$stmt = mysqli_prepare($connexion, "
    SELECT
        l.id,
        l.date_debut,
        l.date_fin,
        l.created_at,
        DATEDIFF(l.date_fin, l.date_debut)             AS nb_jours,
        DATEDIFF(l.date_fin, l.date_debut) * v.prix_jour AS total,
        v.marque, v.modele, v.annee, v.image_path, v.prix_jour,
        CASE
            WHEN CURDATE() < l.date_debut THEN 'a_venir'
            WHEN CURDATE() BETWEEN l.date_debut AND l.date_fin THEN 'en_cours'
            ELSE 'terminee'
        END AS etat
    FROM Locations l
    JOIN Voitures v ON v.id = l.id_voiture
    WHERE l.id_utilisateur = ?
    ORDER BY l.date_debut DESC
");
mysqli_stmt_bind_param($stmt, 'i', $id_user);
mysqli_stmt_execute($stmt);
$locations = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// KPIs utilisateur
$nb_total   = count($locations);
$total_depense = array_sum(array_column($locations, 'total'));
$en_cours   = count(array_filter($locations, fn($l) => $l['etat'] === 'en_cours'));
?>

<main class="container">

    <h1 class="page-title reveal">Mes locations</h1>

    <!-- KPIs -->
    <div class="kpi-grid" style="margin-bottom:3rem;">
        <div class="kpi-card reveal">
            <div class="kpi-value"><?= $nb_total ?></div>
            <div class="kpi-label">Location<?= $nb_total > 1 ? 's' : '' ?> au total</div>
        </div>
        <div class="kpi-card reveal reveal-delay-1">
            <div class="kpi-value"><?= $en_cours ?></div>
            <div class="kpi-label">En cours actuellement</div>
        </div>
        <div class="kpi-card reveal reveal-delay-2">
            <div class="kpi-value"><?= number_format($total_depense, 0, ',', ' ') ?> €</div>
            <div class="kpi-label">Total dépensé</div>
        </div>
    </div>

    <?php if (empty($locations)): ?>
        <div style="text-align:center;padding:5rem 0;color:var(--grey-3);">
            <p style="font-family:var(--font-display);font-size:1.8rem;font-weight:300;color:var(--grey-4);margin-bottom:1rem;">
                Aucune location pour le moment.
            </p>
            <a href="catalogue.php" class="btn btn-primary btn-lg" style="margin-top:1rem;">
                Parcourir le catalogue
            </a>
        </div>
    <?php else: ?>

        <div class="locations-list reveal">
            <?php foreach ($locations as $l): ?>
                <div class="location-row">

                    <div class="location-img">
                        <?php
                            $src = (str_starts_with($l['image_path'], 'http'))
                                ? e($l['image_path'])
                                : e($l['image_path']);
                        ?>
                        <img src="<?= $src ?>" alt="" onerror="this.src='img/default.jpg'">
                    </div>

                    <div class="location-car">
                        <p class="car-meta"><?= e($l['annee']) ?> &mdash; <?= e($l['marque']) ?></p>
                        <h3><?= e($l['modele']) ?></h3>
                        <p style="color:var(--grey-3);font-size:.8rem;margin-top:.3rem;">
                            <?= e($l['prix_jour']) ?> € / jour
                        </p>
                    </div>

                    <div class="location-dates">
                        <div class="location-date-block">
                            <span class="date-label">Début</span>
                            <span class="date-value"><?= date('d/m/Y', strtotime($l['date_debut'])) ?></span>
                        </div>
                        <div class="location-arrow">→</div>
                        <div class="location-date-block">
                            <span class="date-label">Fin</span>
                            <span class="date-value"><?= date('d/m/Y', strtotime($l['date_fin'])) ?></span>
                        </div>
                    </div>

                    <div class="location-meta">
                        <div style="color:var(--gold);font-size:1.2rem;font-weight:300;">
                            <?= number_format($l['total'], 2, ',', ' ') ?> €
                        </div>
                        <div style="color:var(--grey-3);font-size:.75rem;margin-top:.3rem;">
                            <?= $l['nb_jours'] ?> jour<?= $l['nb_jours'] > 1 ? 's' : '' ?>
                        </div>
                    </div>

                    <div class="location-status">
                        <?php
                            $etat_label = match($l['etat']) {
                                'en_cours'  => 'En cours',
                                'a_venir'   => 'À venir',
                                'terminee'  => 'Terminée',
                                default     => ''
                            };
                            $etat_class = match($l['etat']) {
                                'en_cours'  => 'status-active',
                                'a_venir'   => 'status-upcoming',
                                'terminee'  => 'status-done',
                                default     => ''
                            };
                        ?>
                        <span class="location-badge <?= $etat_class ?>"><?= $etat_label ?></span>
                        <div style="color:var(--grey-3);font-size:.72rem;margin-top:.5rem;letter-spacing:.04em;">
                            Réservé le <?= date('d/m/Y', strtotime($l['created_at'])) ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

<?php include 'include/footer.php'; ?>
