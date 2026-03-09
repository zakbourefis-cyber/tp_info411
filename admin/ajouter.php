<?php
$pageTitle = 'Ajouter une voiture';
$rootPath  = '../';
require_once '../include/connexion.php';
requireAdmin('../index.php');

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque     = trim($_POST['marque']     ?? '');
    $modele     = trim($_POST['modele']     ?? '');
    $annee      = (int)($_POST['annee']     ?? 0);
    $prix_jour  = (float)($_POST['prix_jour'] ?? 0);
    $image_path = trim($_POST['image_path'] ?? 'img/default.jpg');
    $statut     = $_POST['statut'] === 'louee' ? 'louee' : 'disponible';

    if (!$marque || !$modele || !$annee || !$prix_jour) {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $stmt = mysqli_prepare($connexion, "INSERT INTO Voitures (marque, modele, annee, prix_jour, image_path, statut) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssidss', $marque, $modele, $annee, $prix_jour, $image_path, $statut);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        redirect('index.php?message=ajout_ok');
    }
}

include '../include/header.php';
include '../include/menu.php';
?>

<main class="container form-page">
    <div class="form-card">
        <h1>Ajouter une voiture</h1>
        <?php if ($erreur): ?><div class="alert alert-error"><?= e($erreur) ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Marque *</label>
                    <input type="text" name="marque" required>
                </div>
                <div class="form-group">
                    <label>Modèle *</label>
                    <input type="text" name="modele" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Année *</label>
                    <input type="number" name="annee" min="2000" max="2099" required>
                </div>
                <div class="form-group">
                    <label>Prix / jour (€) *</label>
                    <input type="number" name="prix_jour" step="0.01" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <label>Chemin de l'image <small>(ex: img/clio.jpg)</small></label>
                <input type="text" name="image_path" value="img/default.jpg">
            </div>
            <div class="form-group">
                <label>Statut</label>
                <select name="statut">
                    <option value="disponible">Disponible</option>
                    <option value="louee">Louée</option>
                </select>
            </div>
            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</main>

<?php include '../include/footer.php'; ?>
