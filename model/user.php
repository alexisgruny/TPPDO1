<?php

class user extends database {

//liste des attributs
    public $id;
    public $lastname;
    public $firstname;
    public $birthdate;
    public $adress;
    public $postalCode;
    public $phone;
    public $service;

    /*
     * Méthode showUser() permet de récuperer les utilisateur et de les montrer
     */

    
    public function showUser() {
        //déclaration de la requête SQL
        $query = 'SELECT `user`.`id`, `user`.`lastname`, `user`.`firstname`, DATE_FORMAT(`user`.`birthDate`, \'%d/%m/%Y\') AS `birthDate`, `user`.`adress`, `user`.`postalCode`, `user`.`phone`, `user`.`service`, `service`.`serviceName`, `service`.`description` '
                . 'FROM `user` '
                . 'INNER JOIN `service` ON `service`.`id` = `user`.`service` ';
        //Préparation de la requête SQL pour éviter les injection de code SQL
        $showUser = $this->db->prepare($query);
        //Remplacement des marqueurs nominatif
        //Execution de la requête SQL
        if ($showUser->execute()) {
            //Si elle fonctionne , elle nous renvois en objet PDO
            return $showUser->fetchAll(PDO::FETCH_OBJ);
        }
    }
    public function showUserLimit() {
        //déclaration de la requête SQL
        $query = 'SELECT `user`.`id`, `user`.`lastname`, `user`.`firstname`, DATE_FORMAT(`user`.`birthDate`, \'%d/%m/%Y\') AS `birthDate`, `user`.`adress`, `user`.`postalCode`, `user`.`phone`, `user`.`service`, `service`.`serviceName`, `service`.`description` '
                . 'FROM `user` '
                . 'INNER JOIN `service` ON `service`.`id` = `user`.`service` '
                . 'LIMIT 5 OFFSET :limitMax';
        //Préparation de la requête SQL pour éviter les injection de code SQL
        $showUser = $this->db->prepare($query);
        //Remplacement des marqueurs nominatif
        $showUser->bindValue(':limitMax', $this->limitMax, PDO::PARAM_INT);
        //Execution de la requête SQL
        if ($showUser->execute()) {
            //Si elle fonctionne , elle nous renvois en objet PDO
            return $showUser->fetchAll(PDO::FETCH_OBJ);
        }
    }
    
    public function showSelectedUser() {
        //déclaration de la requête SQL
        $query = 'SELECT `user`.`id`, `user`.`lastname`, `user`.`firstname`, DATE_FORMAT(`user`.`birthDate`, \'%d/%m/%Y\') AS `birthDate`, `user`.`adress`, `user`.`postalCode`, `user`.`phone`, `user`.`service`, `service`.`serviceName`, `service`.`description` '
                . 'FROM `user` '
                . 'INNER JOIN `service` ON `service`.`id` = `user`.`service` ' 
                . 'WHERE `user`.`service` = :service';
        //Préparation de la requête SQL pour éviter les injection de code SQL
        $showUser = $this->db->prepare($query);
        //Remplacement des marqueurs nominatif
        $showUser->bindValue(':service', $this->service);
        //Execution de la requête SQL
        if ($showUser->execute()) {
            //Si elle fonctionne , elle nous renvois en objet PDO
            return $showUser->fetchAll(PDO::FETCH_OBJ);
        }
    }

    /*
     * Méthode CheckIfUserExist() nous permet d'éviter les doublons dans la base de données
     */

    public function checkIfUserExist() {
        $query = 'SELECT COUNT(`id`) AS `count` FROM `user`'
                . ' WHERE `lastname` = :lastname AND `firstname` = :firstname';
        $check = $this->db->prepare($query);
        $check->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $check->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        } else {
            $bool = FALSE;
        }
        return $bool;
    }

    /*
     * Méthode addUser() nous permet d'ajouter des utilisateurs dans la base de donnée
     */

    public function addUser() {
        $request = 'INSERT INTO `user` ( `lastname`, `firstname`, `birthDate`, `phone`, `adress`, `postalCode`, `service`)'
                . 'VALUES ( :lastname, :firstname, :birthDate, :phone, :adress, :postalCode, :service)';
        $getForm = $this->db->prepare($request);
        $getForm->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $getForm->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $getForm->bindValue(':birthDate', $this->birthDate, PDO::PARAM_STR);
        $getForm->bindValue(':phone', $this->phone, PDO::PARAM_INT);
        $getForm->bindValue(':adress', $this->adress, PDO::PARAM_STR);
        $getForm->bindValue(':postalCode', $this->postalCode, PDO::PARAM_INT);
        $getForm->bindValue(':service', $this->service, PDO::PARAM_INT);
        if ($getForm->execute()) {
            return;
        }
    }

    /*
     * Méthode userDelete() nous permet d'effacer des utilisateurs de la base de donnée
     */

    public function userDelete() {
        $deleteUser = $this->db->prepare('DELETE FROM `user` WHERE `id` = :id');
        $deleteUser->bindValue(':id', $this->id, PDO::PARAM_INT);
        $deleteUser->execute();
        return $deleteUser;
    }

    /*
     *  Méthode userById() vas récupérer un profile avec un ID
     */

    public function userById() {
        $userId = $this->db->prepare('SELECT `user`.`id`, `user`.`lastname`, `user`.`firstname`, DATE_FORMAT(`user`.`birthDate`, \'%d/%m/%Y\') AS `birthDate`, `user`.`adress`, `user`.`postalCode`, `user`.`phone`, `user`.`service`, `service`.`serviceName`, `service`.`description` '
        . 'FROM `user` '
        . 'INNER JOIN `service` ON `service`.`id` = `user`.`service` '
        . 'WHERE `user`.id = :id');
        $userId->bindValue(':id', $this->id, PDO::PARAM_INT);
        $userId->execute();
        if (is_object($userId)) {
            // Stocke la requête dans $userId / fetchAll = va chercher tous les résultat / FETCH_OBJ = un tableau d'objet
            $isObjectResult = $userId->fetch(PDO::FETCH_OBJ);
        }
        // Retourne $PDOResult
        return $isObjectResult;
    }

    /*
     *  Méthode modifyUser() Permet de modifier un utilisateur
     */

    public function modifyUser() {
        $request = 'UPDATE `user` '
                . 'SET `lastname` = :lastname, `firstname` = :firstname, `birthDate` = :birthDate, `phone` = :phone, `adress` = :adress, `postalCode` = :postalCode, `service` = :service '
                . 'WHERE `id` = :id ';
//prépare la requéte sql dans la database
        $modify = $this->db->prepare($request);
        $modify->bindValue(':lastname', $this->lastname);
        $modify->bindValue(':firstname', $this->firstname);
        $modify->bindValue(':birthDate', $this->birthDate);
        $modify->bindValue(':phone', $this->phone);
        $modify->bindValue(':adress', $this->adress);
        $modify->bindValue(':postalCode', $this->postalCode);
        $modify->bindValue(':service', $this->service);
        $modify->bindValue(':id', $this->id);
// si la requéte est préparé , je l'execute
        $updateUser = $modify->execute();
//et je retourne tout les résultat dans un tableau
        return $updateUser;
    }


    public function pageCount() {
        $query = 'SELECT COUNT(`id`) AS `count` FROM `user`';
        $check = $this->db->prepare($query);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
    }
}}

?>
