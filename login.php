<?php
// Include database connection and structural header component
include("connect.php");
include("header.php");

// Initialize an empty error message variable
$error_msg = "";

// Check if the form has been submitted via standard POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pure raw POST extraction, matching exactly your TP habits
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Check if the user is the Global Administrator
    if ($username === 'admin_sae23' && $password === 'je_suis_admin_sae23') {
        $_SESSION['login'] = 'admin';
        $_SESSION['role'] = 'admin';
        
        // Instant redirection to the admin control panel
        header("Location: administration.php");
        exit();
    } 
    // 2. Check for Hardcoded Building Manager E
    elseif ($username === 'gestionnaire_batE' && $password === 'jesuisgestionnaire_batE') {
        $_SESSION['login'] = 'gestionnaire_batE';
        $_SESSION['role'] = 'gestionnaire';
        $_SESSION['id_bat'] = 'E'; // Storing target building ID for future filtering
        
        // Instant redirection to the management panel
        header("Location: gestion.php");
        exit();
    }
    // 3. Check for Hardcoded Building Manager B
    elseif ($username === 'gestionnaire_batB' && $password === 'jesuisgestionnaire_batB') {
        $_SESSION['login'] = 'gestionnaire_batB';
        $_SESSION['role'] = 'gestionnaire';
        $_SESSION['id_bat'] = 'B'; // Storing target building ID for future filtering
        
        // Instant redirection to the management panel
        header("Location: gestion.php");
        exit();
    }
    // 4. If not hardcoded, search inside the 'Batiment' table for dynamic managers
    else {
        // Simple raw query syntax to match login and password fields
        $query = "SELECT * FROM Batiment WHERE Login = '$username' AND Mdp = '$password'";
        $result = mysqli_query($conn, $query);

        // If exactly one row matches, credentials are valid
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            
            $_SESSION['login'] = $row['Login'];
            $_SESSION['role'] = 'gestionnaire';
            $_SESSION['id_bat'] = $row['ID_BAT']; // Dynamic building ID from the database row
            
            header("Location: gestion.php");
            exit();
        } else {
            // Error handling if authentication fails
            $error_msg = "Identifiants incorrects.";
        }
    }
}
?>

<h2>Connexion Requise</h2>
<p>Veuillez vous connecter pour accéder aux outils de gestion ou d'administration.</p>

<?php if ($error_msg != "") { ?>
    <p class="message message-error"><?php echo $error_msg; ?></p>
<?php } ?>

<form action="login.php" method="POST">
    <label for="username">Identifiant :</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Se connecter">
</form>

<?php
// Close MySQL link and call the footer layout
mysqli_close($conn);
include("footer.php");
?>

