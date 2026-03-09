<?php
$pageTitle = 'Inscription';
$rootPath  = '';
require_once 'include/connexion.php';

if (isLoggedIn()) redirect('index.php');

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']    ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email  = trim($_POST['email']  ?? '');
    $mdp    = $_POST['mot_de_passe'] ?? '';
    $mdp2   = $_POST['confirmation'] ?? '';

    if ($mdp !== $mdp2) {
        $erreur = 'Les mots de passe ne correspondent pas.';
    } else {
        // Vérifier si l'email est déjà utilisé
        $stmt = mysqli_prepare($connexion, "SELECT id FROM Utilisateurs WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $existe = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);

        if ($existe) {
            $erreur = 'Cet email est déjà utilisé.';
        } else {
            $hash = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($connexion, "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'ssss', $nom, $prenom, $email, $hash);
            mysqli_stmt_execute($stmt);
            $newId = mysqli_stmt_insert_id($stmt);
            mysqli_stmt_close($stmt);

            $_SESSION['user_id'] = $newId;
            $_SESSION['prenom']  = $prenom;
            $_SESSION['role']    = 'client';
            redirect('index.php');
        }
    }
}

include 'include/header.php';
include 'include/menu.php';
?>

<main class="container form-page">
    <div class="form-card">
        <h1>Créer un compte</h1>
        <?php if ($erreur): ?>
            <div class="alert alert-error"><?= e($erreur) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6">
            </div>
            <div class="form-group">
                <label for="confirmation">Confirmer le mot de passe</label>
                <input type="password" id="confirmation" name="confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Créer mon compte</button>
        </form>
        <p class="form-footer">Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>
</main>

<?php include 'include/footer.php'; ?>
