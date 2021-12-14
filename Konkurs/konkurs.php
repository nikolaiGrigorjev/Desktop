<?php
require_once('conf.php');
global $yhendus;
if(isset($_REQUEST['punkt'])) {
    $kask = $yhendus->prepare("UPDATE konkurs SET punktid=punktid+1 WHERE id = ?");
    $kask->bind_param('i', $_REQUEST['punkt']);
    $kask->execute();
    header("location:$_SERVER[PHP_SELF]");
}
if(isset($_REQUEST['uus_komment'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET kommentarid=CONCAT(kommentarid,?) WHERE id = ?");
    $kommentlisa=$_REQUEST['komment']."\n";
    $kask -> bind_param('si',$kommentlisa,$_REQUEST['uus_komment']);
    $kask -> execute();
    header("location:$_SERVER[PHP_SELF]");
}
?>
<!DOCTYPE html>

<html lang="et">
<head>
    <meta charset="UTF-8">


    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<head>
    <title>FOTO Konkurs</title>
</head>
<body>
<nav>
    <li><a href ="haldus.php">Admin leht</a></li>
    <li><a href ="konkurs.php">Kasutaja leht</a></li>
</nav>
    <h1>Fotokunkurs "Joker"</h1>
<?php
//tabeli konkursi sisu naitamine
$kask=$yhendus->prepare("SELECT id,nimi,kommentarid,pilt,punktid FROM konkurs WHERE avalik=1");
$kask->bind_result($id,$nimi,$kommentarid,$pilt,$punktid);
$kask->execute();
echo "<table>
<tr><td>Nimi</td>
<td>Kommentarid</td>
<td>Lisa Kommentarid</td>
<td>Punktid</td>
<td>Pilt</td>
</tr>";


while ($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<td>".nl2br($kommentarid)."</td>";
    echo "<td>
    <form action ='?'>
        <input type='hidden' name ='uus_komment' value='$id'>
        <input type='text' name ='komment'>
        <input type='submit' value='OK'>
    </form></td>";

    echo "<td>$punktid</td>";

    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td><a href ='?punkt=$id'>+1punkt</a></td>";
    echo"</tr>";


}
echo "<table>";
?>
</body>
</html>