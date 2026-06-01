<?php
// English documented endpoint handling dynamic JSON array parsing
include('includes/db.php');
session_start();

if (!isset($_SESSION['user_role'])) {
    echo json_encode([]);
    exit();
}

if (isset($_GET['batiment_id'])) {
    $bat_id = intval($_GET['batiment_id']);
    
    // SQL query matching your friend's database schema relations
    $query = "SELECT c.NOM_CAPTEUR, c.Type, s.NOM_SALLE 
              FROM capteur c 
              JOIN salle s ON c.NOM_SALLE = s.NOM_SALLE 
              WHERE s.ID_BAT = $bat_id";
              
    $result = mysqli_query($conn, $query);
    $sensors = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $sensors[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($sensors);
    exit();
}
?>
