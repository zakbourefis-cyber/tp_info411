<?php
require_once 'include/connexion.php';
requireLogin('login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('catalogue.php');

$id_voiture = (int)($_POST['id_voiture'] ?? 0);
$date_debut = $_POST['date_debut'] ?? '';
$date_fin   = $_POST['date_fin']   ?? '';
$id_user    = (int)$_SESSION['user_id'];

// Validation de base
if (!$id_voiture || empty($date_debut) || empty($date_fin) || $date_fin <= $date_debut) {
    redirect('catalogue.php?message=erreur');
}

// Vérification chevauchement : la voiture est-elle déjà louée sur cette plage ?
// Chevauchement si : date_debut existante < notre date_fin ET date_fin existante > notre date_debut
$stmt = mysqli_prepare($connexion, "
    SELECT id FROM Locations
    WHERE id_voiture = ?
      AND date_debut < ?
      AND date_fin   > ?
    LIMIT 1
");
mysqli_stmt_bind_param($stmt, 'iss', $id_voiture, $date_fin, $date_debut);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$conflit = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if ($conflit) {
    redirect('catalogue.php?message=conflit');
}

// Insertion de la location
$stmt = mysqli_prepare($connexion, "
    INSERT INTO Locations (id_utilisateur, id_voiture, date_debut, date_fin)
    VALUES (?, ?, ?, ?)
");
mysqli_stmt_bind_param($stmt, 'iiss', $id_user, $id_voiture, $date_debut, $date_fin);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

redirect('catalogue.php?message=location_ok');
