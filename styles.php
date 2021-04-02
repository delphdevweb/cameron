<!DOCTYPE html>
<html lang="en">
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
// Créer, modifier, supprimer et lister tous les styles présents dans la bdd.
 //***************************************************** READ **************************************************************************
        try{
            $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            $requete = "SELECT * FROM `styles`;";
            $prepare = $pdo->prepare($requete);
            $prepare->execute();
            $result = $prepare->fetchAll();
        }
        catch (PDOException $e){
            exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }

        echo "<div class='global_liste'>";
        foreach($result as $keys => $values){
            echo "<div class='liste'>
                  <p>". $values['style_name'] ."</p>
                  </div>";
            } 
            echo "</div>";
        if(!isset($_REQUEST['style_name'])){
    ?>
            <div class="form">
            <h2>Ajouter un style</h2>
            <form action="" method="POST">
                <input type="text" name="style_name" placeholder="Style" required/>
                <input type="submit" value="ajouter" class="valider"/>
            </form>
            </div>
    <?php
     //***************************************************** CREATE **************************************************************************
        }
        elseif(isset($_REQUEST['style_name'])){
            $style_name = $_REQUEST['style_name'];

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "INSERT INTO `styles` (`style_name`)
                VALUES ( :style_name);";
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":style_name" => $style_name
                ));
                $resu = $prepare->rowCount();

                if($resu == 1){
                    echo "<p>Le style a bien été ajouté</p>";
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
                $requete = "SELECT * FROM `styles`;";
                $prepare = $pdo->prepare($requete);
                $prepare->execute();
                $result = $prepare->fetchAll();
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
    ?>
            <div class="form">
            <h2>Modifier un style</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <?php
                    echo "<select name='modif'>";
                    foreach($result as $keys => $values){
                        echo "<option value='". $values['style_id'] ."'>". $values['style_name'] ."</option>";
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
                $requete = "SELECT * FROM `styles`
                            WHERE `style_id` = :style_id ;";
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":style_id" => $modif
                ));
                $result = $prepare->fetchAll();
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }

            echo "<div class='form'>
                <h2>Modifier un style</h2>
                <form action='' method='POST'>
                    <input type='text' name='stylemodif' value='". htmlentities($result[0]['style_name'], ENT_QUOTES) ."' required />
                    <input type='text' name='style_id' value='". $result[0]['style_id'] ."' hidden />
                    <input type='submit' name='modifier' value='modifier' class='valider'/>
                </form> 
                </div>";
        }

        if(isset($_REQUEST['modifier'])){

            $style_name = $_REQUEST['stylemodif'];
            $style_id = $_REQUEST['style_id'];

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "UPDATE `styles` SET
                `style_name` = :style_name
                WHERE `style_id` = :style_id;"; 
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":style_name" => $style_name,
                    ":style_id" => $style_id
                ));
                $resu = $prepare->rowCount();

                if($resu == 1){
                    echo "<p>Le style a bien été modifié</p>";
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
                $requete = "SELECT * FROM `styles`;";
                $prepare = $pdo->prepare($requete);
                $prepare->execute();
                $result = $prepare->fetchAll();
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
    ?>
            <div class="form">
            <h2>Supprimer un style</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <?php
                    echo "<select name='supp'>";
                    foreach($result as $keys => $values){
                        echo "<option value='". $values['style_id'] ."'>". $values['style_name'] ."</option>";
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
            $requete = "SELECT * FROM `styles`
                        WHERE `style_id` = :style_id;";
            $prepare = $pdo->prepare($requete);
            $prepare->execute(array(
                ":style_id" => $supp
            ));
            $result = $prepare->fetchAll();

            echo "<div class='form'>
                <h2>Voulez-vous supprimer ce style ?</h2>
                <form action='' method='POST'>
                    <input type='text' name='stylesupp' value='". htmlentities($result[0]['style_name'], ENT_QUOTES) ."' required />
                    <input type='number' name='style_id' value='". $result[0]['style_id'] ."' hidden />
                    <input type='submit' name='supprimer' value='supprimer' class='valider'/>
                </form> 
                </div>";
        }

        if(isset($_REQUEST['supprimer'])){

            $style_id = $_REQUEST['style_id'];

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "DELETE FROM `styles`
                            WHERE `style_id` = :style_id;"; 
                $prepare = $pdo->prepare($requete);
                $prepare->execute(array(
                    ":style_id" => $style_id
                ));
                $resu = $prepare->rowCount();

                if($resu == 1){
                    echo "<p>Le style a bien été supprimé</p>";
                    //header("Location: styles.php");
                    //exit(); 
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
