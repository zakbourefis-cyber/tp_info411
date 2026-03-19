<?php
require_once 'config.php';

echo "<h1>Test de connexion Docker</h1>";

// Tentative de connexion
$connexion = mysqli_connect($SERVEUR_BD, $LOGIN_BD, $PASS_BD, $NOM_BD, $PORT_BD);

if (!$connexion) {
    echo "<p style='color: red;'>❌ Échec de la connexion : " . mysqli_connect_error() . "</p>";
} else {
    echo "<p style='color: green;'>✅ Succès ! PHP a bien réussi à se connecter à la base de données MariaDB dans Docker.</p>";
}
?>