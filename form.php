<?php

$errors = [];
$isUpload = false;

if($_SERVER["REQUEST_METHOD"] === "POST" ){ 
    
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

$extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

$authorizedExtensions = ['jpg','png','gif','webp'];

$maxFileSize = 1000000;

$fileNewName = uniqid('', true).".".$extension;

// Je sécurise et effectue mes tests

/****** Si l'extension est autorisée *************/
if( (!in_array($extension, $authorizedExtensions))){
    $errors[] = 'Veuillez sélectionner une image de type Jpg ou Png ou GIF ou Webp !';
}

/****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
{
$errors[] = "Votre fichier doit faire moins de 1M !";
}
   
/*on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ça y est, le fichier est uploadé*/
if (empty($errors)) {
    // Déplace le fichier temporaire vers le nouvel emplacement sur le serveur
    $isUpload = move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $fileNewName);
}



}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> file upload</title>
    </head>
        <body>

        <?php
        foreach ($errors as $error) {
echo $errors;
        }?>
        
        

        <form action="form.php" method="post" enctype="multipart/form-data">
        

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom"><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom"><br>

        <label for="age">Âge :</label>
        <input type="text" id="age" name="age"><br>
        
    <label for="imageUpload">Upload a profile image</label>    
    <input type="file" name="avatar" id="imageUpload" />
    <button type="submit">Envoyer</button>
        </form>

        <?php if ($isUpload) {?> 
        <p> <?= $_POST["prenom"] . " " . $_POST ["nom"]?></p>
        
        <img src="/public/uploads/<?= $fileNewName ?>">
        <?php } ?>

        </body>

</html>