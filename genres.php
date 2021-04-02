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

        // Créer, modifier, supprimer et lister tous les genres présents dans la base de données (bdd).
        //***************************************************** READ **************************************************************************
        try{
            $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            $requete = "SELECT * FROM `genres`;";
            $prepare = $pdo->prepare($requete);
            $prepare->execute();
            $resultat = $prepare->fetchAll();
        }
        catch (PDOException $e){
            exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }

        echo "<div class='global_liste'>";
        foreach($resultat as $key => $value){
            echo "<div class='liste'>
                  <p>". $value['genre_name'] ."</p>
                  </div>";
            } 
            echo "</div>";

        if(!isset($_REQUEST['genre_name'])){
    ?>
            <div class="form">
            <h2>Ajouter un genre </h2>
            <form action="" method="POST">
                <input type="text" name="genre_name" placeholder="Genre" required/>
                <input type="submit" value="ajouter" class="valider"/>
            </form>
            </div>

    <?php
        }
         //***************************************************** CREATE **************************************************************************
        elseif(isset($_REQUEST['genre_name'])){
            $genre_name = $_REQUEST['genre_name'];

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "INSERT INTO `genres` (`genre_name`)
                VALUES ( :genre_name);";
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":genre_name" => $genre_name
                ));
                $res = $prepare->rowCount();

                if($res == 1){
                    header("Location: genres.php");
                    exit(); 
                }
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
        }
         //***************************************************** UPDATE **************************************************************************
        if(!isset($_REQUEST['modif'])){

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "SELECT * FROM `genres`;";
                $prepare = $pdo->prepare($requete);
                $prepare->execute();
                $resultat = $prepare->fetchAll();
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
    ?>
            <div class="form">
            <h2>Modifier un genre </h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <?php
                    echo "<select name='modif'>";
                    foreach($resultat as $key => $value){
                        echo "<option value='". $value['genre_id'] ."'>". $value['genre_name'] ."</option>";
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
                $requete = "SELECT * FROM `genres`
                            WHERE `genre_id` = :genre_id ;";
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":genre_id" => $modif
                ));
                $resultat = $prepare->fetchAll();
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }

            echo "<div class='form'>
                <h2>Modifier un genre</h2>
                <form action='' method='POST'>
                    <input type='text' name='genremodif' value='". htmlentities($resultat[0]['genre_name'], ENT_QUOTES) ."' required />
                    <input type='text' name='genre_id' value='". $resultat[0]['genre_id'] ."' hidden />
                    <input type='submit' name='modifier' value='Modifier' class='valider'/>
                </form> 
                </div>";
        }

        if(isset($_REQUEST['modifier'])){

            $genre_name = $_REQUEST['genremodif'];
            $genre_id = $_REQUEST['genre_id'];

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "UPDATE `genres` SET
                `genre_name` = :genre_name
                WHERE `genre_id` = :genre_id;"; 
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":genre_name" => $genre_name,
                    ":genre_id" => $genre_id
                ));
                $res = $prepare->rowCount();

                if($res == 1){
                    header("Location: genres.php");
                    exit(); 
                }
        
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
        }
    //***************************************************** DELETE **************************************************************************
        if(!isset($_REQUEST['supp'])){

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "SELECT * FROM `genres`;";
                $prepare = $pdo->prepare($requete);
                $prepare->execute();
                $resultat = $prepare->fetchAll();
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
    ?>
            <div class="form">
            <h2>Supprimer un genre </h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <?php
                    echo "<select name='supp'>";
                    foreach($resultat as $key => $value){
                        echo "<option value='". $value['genre_id'] ."'>". $value['genre_name'] ."</option>";
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
            $requete = "SELECT * FROM `genres`
                        WHERE `genre_id` = :genre_id;";
            $prepare = $pdo->prepare($requete);
            $prepare->execute(array(
                ":genre_id" => $supp
            ));
            $resultat = $prepare->fetchAll();

            echo "<div class='form'>
                <h2>Voulez-vous supprimer ce genre ?</h2>
                <form action='' method='POST'>
                    <input type='text' name='genresupp' value='". htmlentities($resultat[0]['genre_name'], ENT_QUOTES) ."' required />
                    <input type='number' name='genre_id' value='". $resultat[0]['genre_id'] ."' hidden />
                    <input type='submit' name='supprimer' value='supprimer' class='valider'/>
                </form> 
                </div>";
        }

        if(isset($_REQUEST['supprimer'])){

            $genre_id = $_REQUEST['genre_id'];

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "DELETE FROM `genres`
                            WHERE `genre_id` = :genre_id;"; 
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":genre_id" => $genre_id
                ));
                $res = $prepare->rowCount();

                if($res == 1){
                    header("Location: genres.php");
                    exit(); 
                }
        
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
        }

?>
<div class="accueil">
    <button class="retour"> 
        <a href='index.php'>Retour</a>
    </button>
</div>
</body>
</html>
