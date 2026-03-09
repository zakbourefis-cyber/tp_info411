<?php
$pageTitle = 'Administration';
$rootPath  = '../';
require_once '../include/connexion.php';
requireAdmin('../index.php');
include '../include/header.php';
include '../include/menu.php';

$stmt = mysqli_prepare($connexion, "SELECT * FROM Voitures ORDER BY marque, modele");
mysqli_stmt_execute($stmt);
$voitures = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

$msg = $_GET['message'] ?? null;
?>

<main class="container">

    <div class="admin-header">
        <h1 class="page-title" style="margin-bottom:0; padding-bottom:0;">
            <span style="font-size:.7em;color:var(--grey-3);display:block;letter-spacing:.15em;font-family:var(--font-ui);font-size:.75rem;margin-bottom:.5rem;">ADMINISTRATION</span>
            Gestion des voitures
        </h1>
        <div style="display:flex;gap:.75rem;">
            <a href="locations.php" class="btn btn-outline">Suivi des locations</a>
            <a href="ajouter.php"   class="btn btn-primary">+ Ajouter une voiture</a>
        </div>
    </div>

    <?php if ($msg === 'ajout_ok'):       ?><div class="alert alert-success">Voiture ajoutée avec succès.</div><?php endif; ?>
    <?php if ($msg === 'modif_ok'):       ?><div class="alert alert-success">Voiture modifiée avec succès.</div><?php endif; ?>
    <?php if ($msg === 'suppression_ok'): ?><div class="alert alert-success">Voiture supprimée.</div><?php endif; ?>

    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Prix / jour</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voitures as $v): ?>
                <tr>
                    <td style="color:var(--grey-3)"><?= $v['id'] ?></td>
                    <td>
                        <?php
                            // Si le chemin est une URL externe on l'utilise tel quel,
                            // sinon on remonte d'un niveau (admin/ → racine)
                            $src = (str_starts_with($v['image_path'], 'http'))
                                ? e($v['image_path'])
                                : '../' . e($v['image_path']);
                        ?>
                        <img src="<?= $src ?>"
                             alt="<?= e($v['marque'] . ' ' . $v['modele']) ?>"
                             class="admin-thumb"
                             onerror="this.src='../img/default.jpg'">
                    </td>
                    <td><?= e($v['marque']) ?></td>
                    <td><?= e($v['modele']) ?></td>
                    <td><?= e($v['annee']) ?></td>
                    <td><?= number_format($v['prix_jour'], 2, ',', ' ') ?> €</td>
                    <td>
                        <span class="car-badge <?= $v['statut'] === 'disponible' ? 'badge-available' : 'badge-rented' ?>">
                            <?= $v['statut'] ?>
                        </span>
                    </td>
                    <td class="actions">
                        <a href="modifier.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-outline">Modifier</a>
                        <a href="supprimer.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Supprimer cette voiture ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<?php include '../include/footer.php'; ?>
