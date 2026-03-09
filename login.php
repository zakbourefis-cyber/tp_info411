<?php
$pageTitle = 'Connexion';
$rootPath  = '';
require_once 'include/connexion.php';

if (isLoggedIn()) redirect('index.php');

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mdp   = $_POST['mot_de_passe'] ?? '';

    $stmt = mysqli_prepare($connexion, "SELECT id, prenom, mot_de_passe, role FROM Utilisateurs WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($user && password_verify($mdp, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['prenom']  = $user['prenom'];
        $_SESSION['role']    = $user['role'];
        redirect('index.php');
    } else {
        $erreur = 'Email ou mot de passe incorrect.';
    }
}

include 'include/header.php';
include 'include/menu.php';
?>

<main class="container form-page">
    <div class="form-card">
        <h1>Connexion</h1>
        <?php if ($erreur): ?>
            <div class="alert alert-error"><?= e($erreur) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        <p class="form-footer">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
    </div>
</main>

<?php include 'include/footer.php'; ?>
