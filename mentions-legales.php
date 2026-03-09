<?php
$pageTitle = 'Mentions légales';
$rootPath  = '';
require_once 'include/connexion.php';
include 'include/header.php';
include 'include/menu.php';
?>

<main class="container">
    <h1 class="page-title reveal">Mentions légales</h1>

    <div class="legal-content reveal">

        <section class="legal-section">
            <h2>Éditeur du site</h2>
            <p>DriveNow SAS<br>
               123 Avenue des Voitures<br>
               75001 Paris, France<br>
               Tél. : 01 23 45 67 89<br>
               Email : contact@drivenow.fr</p>
        </section>

        <section class="legal-section">
            <h2>Hébergement</h2>
            <p>Ce site est hébergé localement via XAMPP dans le cadre d'un projet pédagogique (INFO411).</p>
        </section>

        <section class="legal-section">
            <h2>Propriété intellectuelle</h2>
            <p>L'ensemble des contenus présents sur ce site (textes, images, structure) sont la propriété exclusive de DriveNow SAS.
               Toute reproduction, même partielle, est interdite sans autorisation préalable.</p>
        </section>

        <section class="legal-section">
            <h2>Données personnelles</h2>
            <p>Les informations collectées lors de l'inscription (nom, prénom, email) sont uniquement utilisées
               pour la gestion des réservations. Elles ne sont transmises à aucun tiers.
               Conformément au RGPD, vous disposez d'un droit d'accès, de rectification et de suppression
               de vos données en nous contactant à l'adresse ci-dessus.</p>
        </section>

    </div>
</main>

<?php include 'include/footer.php'; ?>
