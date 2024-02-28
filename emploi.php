<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
// $tab_mat = [
//     "lundi" => ['08-09' => 'Math', '09-10' => 'info', '10-11' => 'java'],
//     "mercredi" => ['09-10' => 'Math', '14-15' => 'info', '15-16' => 'java'],
//     "samedi" => ['08-09' => 'physique', '09-10' => 'français', '10-11' => 'Anglais'],
// ];
$heures = ['08-09', '09-10', '10-11', '11-12', '12-13', '13-14', '14-15', '15-16', '16-17'];
$jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];

$tab_mat=[];
if(isset($_SESSION['tab_mat'])){
    $tab_mat=($_SESSION['tab_mat']);
}
if(isset($_POST["submit"])){
    $jour=$_POST["jour"];
    $heure=$_POST["heure"];
    $matiere=$_POST["matiere"];
    $tab_mat[$jour][$heure]=$matiere;
    $_SESSION['tab_mat']=$tab_mat;
    }
    if(isset($_GET["action"])&& ($_GET["action"]=='delete')){
$jour=$_GET['jour'];
$heure=$_GET['heure'];
unset($tab_mat[$jour][$heure]);
$_SESSION["tab_mat"]=$tab_mat;
header("location:emploi.php");
    }
if(isset($_GET['action']) && $_GET['action']==="viderEmploi"){
    unset($_SESSION['tab_mat']);
    header("location:emploi.php");
    }

?>
<form action="emploi.php" method="post">
<label for="jour">Jour</label>
<select name="jour" id="jour" required>
<option value="">Choisir le jours</option>
<?php
foreach ($jours as $jour)
echo "<option value='$jour'>$jour</option>";
?>
</select>
<label for="heure">Heure</label>
<select name="heure" id="heure" required>
<option value="">Choisir l'heure</option>
<?php
foreach ($heures as $heure)
echo "<option value='$heure'>$heure</option>";
?>
</select>
<label for="matiere">Matière</label>
<input type="text" name="matiere" required>
<button type="submit" name="submit">Ajouter</button>
<button type="button" onclick="window.print()">imprimer emploi</button>
<button type="button"
onclick="window.location.href='emploi.php?action=viderEmploi'">Nouveau emploi</button>
</form>
<hr>
<?php
echo "<h1>Emploi du temps</h1>";
echo "<small>".date("d/m/Y H:i:s")."</small>";
echo "<table border ='1'>
<tr><td></td>";
foreach ($heures as $heure) {
    echo "<td>$heure</td>";
}

echo "</tr>";
foreach ($jours as $jour) {
    echo "<tr><td>$jour</td>";
    foreach($heures as $heure)
    if(isset($tab_mat["$jour"]["$heure"]))
    {
            echo "<td>".$tab_mat["$jour"]["$heure"];
            echo "<a href='emploi.php?jour=$jour&heure=$heure&action=delete'><button >X</button></a></td>";

    }
    else
    echo "<td></td>";
    echo "</tr>";

    
}
echo "</table>";

?>
</body>
</html>