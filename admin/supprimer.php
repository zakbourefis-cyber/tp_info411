<?php
require_once '../include/connexion.php';
requireAdmin('../index.php');

$id = (int)($_GET['id'] ?? 0);
if (!$id) redirect('index.php');

$stmt = mysqli_prepare($connexion, "DELETE FROM Voitures WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

redirect('index.php?message=suppression_ok');
