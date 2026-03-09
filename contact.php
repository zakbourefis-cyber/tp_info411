<?php
$pageTitle = 'Contact';
$rootPath  = '';
require_once 'include/connexion.php';
include 'include/header.php';
include 'include/menu.php';
?>

<main class="container form-page">
    <div class="form-card">
        <h1>Contactez-nous</h1>
        <p class="form-subtitle">Une question ? Besoin d'aide ? Écrivez-nous !</p>
        <form method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Envoyer</button>
        </form>
        <div class="contact-info">
            <p>📍 123 Avenue des Voitures, 75001 Paris</p>
            <p>📞 01 23 45 67 89</p>
            <p>✉️ contact@drivenow.fr</p>
        </div>
    </div>
</main>

<?php include 'include/footer.php'; ?>
