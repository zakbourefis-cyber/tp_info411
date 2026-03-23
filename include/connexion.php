<?php
// 1. OBLIGATOIRE : On charge les fonctions et les sessions EN PREMIER
require_once __DIR__ . '/fonctions.php'; 

// 2. OBLIGATOIRE : On utilise __DIR__ pour être sûr de toujours trouver connect.php
require_once __DIR__ . '/../config.php';

// 3. Connexion au serveur (avec $connexion en minuscules !)
$connexion = mysqli_connect($SERVEUR_BD, 
                            $LOGIN_BD, 
                            $PASS_BD, 
                            $NOM_BD, 
                            $PORT_BD);

if (mysqli_connect_errno()) {
    echo 'Désolé, connexion au serveur ' . $SERVEUR_BD . ' impossible, ' . mysqli_connect_error(), "\n";
    exit();
}

// 4. Sélection de la base de données
mysqli_select_db($connexion, $NOM_BD);

if (mysqli_connect_errno()) {
    echo 'Désolé, accès à la base ' . $NOM_BD . ' impossible, ' . mysqli_connect_error(), "\n";
    exit();
}

// 5. Spécification de l'encodage UTF-8 pour dialoguer avec la BD
if (!mysqli_set_charset($connexion, 'UTF8')) {
    echo 'Erreur au chargement de l\'encodage UTF-8 : ', mysqli_connect_error(), "\n";
}