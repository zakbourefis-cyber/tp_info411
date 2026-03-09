<?php
$pageTitle = 'Modifier une voiture';
$rootPath  = '../';
require_once '../include/connexion.php';
requireAdmin('../index.php');

$id = (int)($_GET['id'] ?? 0);
if (!$id) redirect('index.php');

$stmt = mysqli_prepare($connexion, "SELECT * FROM Voitures WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$voiture = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$voiture) redirect('index.php');

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque     = trim($_POST['marque']     ?? '');
    $modele     = trim($_POST['modele']     ?? '');
    $annee      = (int)($_POST['annee']     ?? 0);
    $prix_jour  = (float)($_POST['prix_jour'] ?? 0);
    $image_path = trim($_POST['image_path'] ?? '');
    $statut     = $_POST['statut'] === 'louee' ? 'louee' : 'disponible';

    if (!$marque || !$modele || !$annee || !$prix_jour) {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $stmt = mysqli_prepare($connexion, "UPDATE Voitures SET marque=?, modele=?, annee=?, prix_jour=?, image_path=?, statut=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssidssi', $marque, $modele, $annee, $prix_jour, $image_path, $statut, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        redirect('index.php?message=modif_ok');
    }
}

include '../include/header.php';
include '../include/menu.php';
?>

<main class="container form-page">
    <div class="form-card">
        <h1>Modifier une voiture</h1>
        <?php if ($erreur): ?><div class="alert alert-error"><?= e($erreur) ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Marque *</label>
                    <input type="text" name="marque" value="<?= e($voiture['marque']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Modèle *</label>
                    <input type="text" name="modele" value="<?= e($voiture['modele']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Année *</label>
                    <input type="number" name="annee" value="<?= $voiture['annee'] ?>" min="2000" max="2099" required>
                </div>
                <div class="form-group">
                    <label>Prix / jour (€) *</label>
                    <input type="number" name="prix_jour" value="<?= $voiture['prix_jour'] ?>" step="0.01" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <label>Chemin de l'image</label>
                <input type="text" name="image_path" value="<?= e($voiture['image_path']) ?>">
            </div>
            <div class="form-group">
                <label>Statut</label>
                <select name="statut">
                    <option value="disponible" <?= $voiture['statut'] === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                    <option value="louee"      <?= $voiture['statut'] === 'louee'      ? 'selected' : '' ?>>Louée</option>
                </select>
            </div>
            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</main>

<?php include '../include/footer.php'; ?>
