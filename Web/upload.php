<?php
session_start();
require('BDDConnect.php');
$co = getConnection();
$_FILES['fichier']['name'];    //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['fichier']['type'];   //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['fichier']['size'];  //La taille du fichier en octets.
$_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['fichier']['error'];//Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé
$titre = $_POST['titre'];
$req = $co->prepare("SELECT COUNT(*) FROM oeuvre WHERE Nom ='$titre' ");
$req->execute(array($titre));
if(($req -> fetchColumn() == 0)) {
  $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
  //1. strrchr renvoie l'extension avec le point (« . »).
  //2. substr(chaine,1) ignore le premier caractère de chaine.
  //3. strtolower met l'extension en minuscules.
  $extension_upload = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );
  if (! in_array($extension_upload,$extensions_valides) ) {
    echo "Extension incorrecte";
  }

  //1.On recupère la taille de l'image
  $image_sizes = getimagesize($_FILES['fichier']['tmp_name']);
  if ($_FILES['fichier']['size'] > 10000)  {
    $erreur = "Image trop grande";
  }

  $path = "imgs/{$titre}.{$extension_upload}";
  $nom = "{$titre}.{$extension_upload}";
  $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$path);
  if ($resultat) {
    $desc= $_POST['desc'];
    $user = $_SESSION['user'];
    $query = $co -> prepare("INSERT INTO oeuvre(Nom,Description,Path,User) VALUES ('$titre','$desc','$nom','$user')");
    $query->execute();
    header('Location: contentphp/galerie.php');
    exit();
  }
} else {
  header('Location: contentphp/ajouter.php?mes=error&attri=Nom deja utilisé');
  exit();
}




?>
