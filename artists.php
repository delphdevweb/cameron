<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cameron</title>
</head>
<body>
<?php
        require "tables.dbconf.php";
   // $requete = "SELECT * FROM `assoc_styles_artists`
   //             JOIN artists ON artists.artist_id = assoc_styles_artists.assoc_artists_id
   //             JOIN styles ON styles.style_id = assoc_styles_artists.assoc_styles_id;";
        try{
            $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            $requete = "SELECT * FROM `artists`;";
            $prepare = $pdo->prepare($requete);
            $prepare->execute();
            $artishow = $prepare->fetchAll();
        }
        catch (PDOException $e){
            exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }

        echo "<div class='global_liste'>";
        foreach($artishow as $keys => $marronshow){
            echo "<div class='liste'>
                  <p>". $marronshow['artist_name'] ."</p>
                  </div>";
            } 
            echo "</div>";

            //try {
            //    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            //    $requete = "SELECT * FROM `artists`
            //                WHERE artist_id = :artist_id;";
            //    $prepare = $pdo->prepare($requete);
            //    $prepare->execute(array(
            //      ':artist_id' => $artist_id
            //    ));
            //    $resultatA = $prepare->fetchAll();
            //  } catch (PDOException $e) {
            //    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            //  }

            //try {
            //    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            //    $requete = "SELECT * FROM `styles`
            //                JOIN assoc_styles_artists ON assoc_styles_id = style_id
            //                WHERE assoc_artists_id = :artist_id;";
            //    $prepare = $pdo->prepare($requete);
            //    $prepare->execute(array(
            //      ':artistId' => $artistId
            //    ));
            //    $join = $prepare->fetchAll();
            //  } catch (PDOException $e) {
            //    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            //  }

    if(!isset($_REQUEST['artist_name'])){
        try{
            $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            $requete = "SELECT * FROM `artists`";
                     
            $prepare = $pdo->prepare($requete);
            $prepare->execute();
            $artishow = $prepare->fetchAll();
        }
        catch (PDOException $e){
            exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }
        ?>
                <div class="form">
                <h2>Ajouter un artiste</h2>
                <form action="" method="POST">
                    <input type="text" name="artist_name" placeholder="Artiste" required/>
                    <input type="submit" value="ajouter" class="valider"/>
                </form>
                </div>
        <?php
            }
            elseif(isset($_REQUEST['artist_name'])){
                $artist_name = $_REQUEST['artist_name'];
    
                try{
                    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                    $requete = "INSERT INTO `artists` (`artist_name`)
                    VALUES ( :artist_name);";
                    $prepare = $pdo->prepare($requete);
                    $prepare->execute(array(
                        ":artist_name" => $artist_name
                    ));
                    $rezu = $prepare->rowCount();
    
                    if($rezu == 1){
                        echo "<p>L'artiste a bien été ajouté</p>";
                    }
                }
                catch (PDOException $e){
                    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                }

            }


        //try {
        //  $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        //  $requete = "INSERT INTO `assoc_styles_artists` (`assoc_artists_id`, `assoc_styles_id`)
        //              VALUES (:assoc_artists_id, :assoc_styles_id);";
        //  $prepare = $pdo->prepare($requete);
        //  $prepare->execute(array(
        //      ':assoc_artists_id' => $lastInsertedId,
        //      ':assoc_styles_id' => $styles_id
        //  ));
      
        //  } catch (PDOException $e) {
        //    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        //  }
    
            if(!isset($_REQUEST['modif'])){
    
                try{
                    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                    $requete = "SELECT * FROM `artists`;";
                    $prepare = $pdo->prepare($requete);
                    $prepare->execute();
                    $artishow = $prepare->fetchAll();
                }
                catch (PDOException $e){
                    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                }
        ?>
                <div class="form">
                <h2>Modifier un artiste</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php
                        echo "<select name='modif'>";
                        foreach($artishow as $keys => $marronshow){
                            echo "<option value='". $marronshow['artist_id'] ."'>". $marronshow['artist_name'] ."</option>";
                        }
                        echo "</select>";
                    ?>
                    <input type="submit" value="ok" class="valider"/>
                </form>
                </div>
    
        <?php
            }
            elseif(isset($_REQUEST['modif'])){
    
                $modif = $_REQUEST['modif'];
    
                try{
                    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                    $requete = "SELECT * FROM `artists`
                                WHERE `artist_id` = :artist_id ;";
                    $prepare = $pdo->prepare($requete);
                    $prepare->execute(array(
                        ":artist_id" => $modif
                    ));
                    $artishow = $prepare->fetchAll();
                }
                catch (PDOException $e){
                    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                }
    
                echo "<div class='form'>
                    <h2>Modifier un artiste</h2>
                    <form action='' method='POST'>
                        <input type='text' name='artistmodif' value='". htmlentities($artishow[0]['artist_name'], ENT_QUOTES) ."' required />
                        <input type='text' name='artist_id' value='". $artishow[0]['artist_id'] ."' hidden />
                        <input type='submit' name='modifier' value='modifier' class='valider'/>
                    </form> 
                    </div>";
            }
    
            if(isset($_REQUEST['modifier'])){
    
                $artist_name = $_REQUEST['artistmodif'];
                $artist_id = $_REQUEST['artist_id'];
    
                try{
                    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                    $requete = "UPDATE `artists` SET
                    `artist_name` = :artist_name
                    WHERE `artist_id` = :artist_id;"; 
                    $prepare = $pdo->prepare($requete);
                    $prepare->execute(array(
                        ":artist_name" => $artist_name,
                        ":artist_id" => $artist_id
                    ));
                    $rezu = $prepare->rowCount();
    
                    if($rezu == 1){
                        echo "<p>L'artiste a bien été modifié</p>";
                    }
            
                }
                catch (PDOException $e){
                    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                }
            }

            //try {
            //    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            //    $requete = "UPDATE `artists` SET `artist_name` = :artist_name 
            //                WHERE `artist_id` = :artist_id;";
            //    $prepare = $pdo->prepare($requete);
            //    $prepare->execute(array(
            //      ':artist_id' => $artist_id,
            //      ':artist_name' => $artist_name
            //    ));      
            //  } catch (PDOException $e) {
            //    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            //  }
    
            if(!isset($_REQUEST['supp'])){
    
                try{
                    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                    $requete = "SELECT * FROM `artists`;";
                    $prepare = $pdo->prepare($requete);
                    $prepare->execute();
                    $artishow = $prepare->fetchAll();
                }
                catch (PDOException $e){
                    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                }
        ?>
                <div class="form">
                <h2>Supprimer un artiste</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php
                        echo "<select name='supp'>";
                        foreach($artishow as $keys => $marronshow){
                            echo "<option value='". $marronshow['artist_id'] ."'>". $marronshow['artist_name'] ."</option>";
                        }
                        echo "</select>";
                    ?>
                    <input type="submit" value="ok" class="valider"/>
                </form>
                </div>
    
        <?php
            }
            elseif(isset($_REQUEST['supp'])){
    
                $supp = $_REQUEST['supp'];
    
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "SELECT * FROM `artists`
                            WHERE `artist_id` = :artist_id;";
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":artist_id" => $supp
                ));
                $artishow = $prepare->fetchAll();
    
                echo "<div class='form'>
                    <h2>Voulez-vous supprimer cet artiste ?</h2>
                    <form action='' method='POST'>
                        <input type='text' name='artistsupp' value='". htmlentities($artishow[0]['artist_name'], ENT_QUOTES) ."' required />
                        <input type='number' name='artist_id' value='". $artishow[0]['artist_id'] ."' hidden />
                        <input type='submit' name='supprimer' value='supprimer' class='valider'/>
                    </form> 
                    </div>";
            }
    
            if(isset($_REQUEST['supprimer'])){
    
                $artist_id = $_REQUEST['artist_id'];
    
                try{
                    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                    $requete = "DELETE FROM `artists`
                                WHERE `artist_id` = :artist_id;"; 
                    $prepare = $pdo->prepare($requete);
                    $prepare->execute(array(
                        ":artist_id" => $artist_id
                    ));
                    $rezu = $prepare->rowCount();
    
                    if($rezu == 1){
                        echo "<p>L'artiste a bien été supprimé</p>";
                    }
            
                }
                catch (PDOException $e){
                    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                }

                //try {
                //    $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                //    $requete = "DELETE FROM `assoc_artists_styles`
                //                WHERE assoc_artists_id = :artist_id";
                //    $prepare = $pdo->prepare($requete);
                //    $prepare->execute(array(
                //      ':artist_id' => $artist_id
                //    ));      
                //  } catch (PDOException $e) {
                //    exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                //  }
                
            }

?>
<div class="accueil">
    <button class="retour"> 
        <a href='index.php'>Retour</a>
    </button>
</div>
</body>
</html>
