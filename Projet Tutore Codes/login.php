<?php
/*
================================================

    Nom : Mungly Sydney
    Mail: sydneymungly15@gmail.com
    Description : Projet Tut.
    Date: Fevrier 2018

================================================
*/

require_once "classes/Config.php";

$uname = $_POST["uname"];
$pswd = $_POST["pswd"];

$sql = "SELECT UNAME, MDP, ID_MEMBRE, TYPE, STATUT, EMAIL FROM `membres` WHERE UNAME = '{$uname}' AND STATUT = 'Actif'";

 try{

    // Instantiasiation
    $bdd = new Connect();

    // Ouverture de la connexion
    $db = $bdd->ouvrir();

    $stmt = $db->prepare($sql);

    $stmt->execute(
        array(
            'uname' => $uname
        )
    );

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($pswd, $res['MDP'])){
        
        session_start();

    // Donnees trouvees
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $uname;
        $_SESSION["id"] = $res['ID_MEMBRE'];
        $_SESSION["email"] = $res['EMAIL'];

        if ($res['TYPE'] == 1){
            echo "Success";
        }
        else if($res['TYPE'] == 0){
            $_SESSION["type"] = $res['TYPE'];
            echo "Super User";
        }
    }
    else if(password_verify($pswd, $res['MDP']) && $res['UNAME'] == $uname && $res['STATUT'] == 'Inactif'){
        // Informations incorrectes
        echo "Mot de passe ou nom utilisateur incorrecte.";
        
    }else{
         // Pas de donnees trouvees
        echo "Mot de passe ou nom utilisateur incorrecte.";
    }
 }
 catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.";
 }   

 // Fermer la connexion

    $db = $bdd->fermer();
    exit(0);

?>