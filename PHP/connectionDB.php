<?php

namespace DB;

class DBAccess {

    private const HOST_DB = "localhost";
    private const USERNAME = "mmasetto";
    private const PASSWORD = "iyuyiSohS5oochu3";
    private const DATABASE_NAME = "mmasetto";

    private $connection;

    public function openDBConnection() {
        $this->connection = mysqli_connect(DBAccess::HOST_DB,
                                           DBAccess::USERNAME,
                                           DBAccess::PASSWORD,
                                           DBAccess::DATABASE_NAME);

        if (!$this->connection) {
            return false;
        } else {
            mysqli_query($this->connection, "SET lc_time_names = 'it_IT'");
            return true;
        }
    }

    public function closeDBConnection() {
        if ($this->connection)
            mysqli_close($this->connection);
    }

    /*
        LOGIN
    */
    public function checkLogin($email, $username, $password) {
        $txtEmail = mysqli_real_escape_string($this->connection, $email);
        $txtUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT *
                FROM UTENTE
                WHERE BINARY username = '$txtUsername' AND password = '$password'";

        $result = mysqli_query($this->connection, $sql);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            return array(
                "isValid" => true,
                "email" => $user["email"],
                "isAdmin" => $user["isAdmin"]
            );
        }
        return array(
            "isValid" => false,
            "email" => null,
            "isAdmin" => false
        );
    }
    /*
        FINE LOGIN
    */

    /*
        REGISTRA NUOVO
    */
    public function createNewUser($email,$username, $password) {
        $txtUsername = mysqli_real_escape_string($this->connection, $username);
        $txtEmail = mysqli_real_escape_string($this->connection, $email);
        $txtPass = mysqli_real_escape_string($this->connection, $password);
        $sql = sprintf("SELECT *
                FROM UTENTE
                WHERE username = '%s' OR email='%s'",$txtUsername,$txtEmail);

        $result = mysqli_query($this->connection, $sql);
        if (mysqli_num_rows($result) == 0) {
            //Nessun utente trovato con quel username o email, quindi creazione disponibile
            $sql = sprintf("INSERT INTO `UTENTE` (`email`, `username`, `password`)
            VALUES ('%s', '%s', '%s')",$txtEmail,$txtUsername,$txtPass);
            $result = mysqli_query($this->connection, $sql);

            return ($result == true);
            //ritorna true SSE l'utente è stato creato
        }
        else
        {
            return false;
        }
    }
    /*
        FINE REGISTRA NUOVO
    */

    private function execQuery($query) {
        $queryResult = mysqli_query($this->connection, $query) or die("Errore: ".mysqli_error($this->connection));

        if ($queryResult && mysqli_num_rows($queryResult) > 0) {

            $result = array();
            while ($row = mysqli_fetch_assoc($queryResult)) {
                array_push($result, $row);
            }
            return $result;
        }
        return null;
    }

    public function getIngredients($pizza) {
        $query = "SELECT INGREDIENTE.nome, allergene
                  FROM INGREDIENTE JOIN COMPOSIZIONE ON INGREDIENTE.id_ingrediente = COMPOSIZIONE.id_ingrediente
                  WHERE COMPOSIZIONE.nome = '$pizza'
                  ORDER BY COMPOSIZIONE.id_ingrediente";
        return $this->execQuery($query);
    }

    public function getClassiche() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, descrizione
                  FROM PIZZA INNER JOIN ELEMENTO_LISTINO ON PIZZA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'classiche'";
        return $this->execQuery($query);
    }

    public function getSpeciali() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, descrizione
                  FROM PIZZA INNER JOIN ELEMENTO_LISTINO ON PIZZA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'speciali'";
        return $this->execQuery($query);
    }

    public function getBianche() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, descrizione
                  FROM PIZZA INNER JOIN ELEMENTO_LISTINO ON PIZZA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'bianche'";
        return $this->execQuery($query);
    }

    public function getCalzoni() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, descrizione
                  FROM PIZZA INNER JOIN ELEMENTO_LISTINO ON PIZZA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'calzoni'";
        return $this->execQuery($query);
    }

    public function getBevande() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, gradiAlcolici, descrizione
                  FROM BEVANDA INNER JOIN ELEMENTO_LISTINO ON BEVANDA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'bevande analcoliche'";
        return $this->execQuery($query);
    }

    public function getBirre() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, gradiAlcolici, descrizione
                  FROM BEVANDA INNER JOIN ELEMENTO_LISTINO ON BEVANDA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'birre'";
        return $this->execQuery($query);
    }

    public function getVini() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, gradiAlcolici, descrizione
                  FROM BEVANDA INNER JOIN ELEMENTO_LISTINO ON BEVANDA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'vini'";
        return $this->execQuery($query);
    }

    public function getDolci() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, descrizione
                  FROM DOLCE INNER JOIN ELEMENTO_LISTINO ON DOLCE.nome = ELEMENTO_LISTINO.nome";
        return $this->execQuery($query);
    }

    public function getPrenotazioni($account) {
        $query = "SELECT dataOra, persone
                  FROM PRENOTAZIONE
                  WHERE email = '$account'
                  ORDER BY dataOra DESC";
        return $this->execQuery($query);
    }

    public function getUserInfo($email) {
        $query = "SELECT *
                  FROM UTENTE
                  WHERE email = '$email'";
        return $this->execQuery($query);
    }

    public function setUserInfo($email, $new_email, $new_username, $new_pwd, $new_birthday) {
        $_new_email = mysqli_real_escape_string($this->connection, $new_email);
        $_new_username = mysqli_real_escape_string($this->connection, $new_username);
        $_new_pwd = mysqli_real_escape_string($this->connection, $new_pwd);
        $_new_birthday = mysqli_real_escape_string($this->connection, $new_birthday);
        $query = "UPDATE UTENTE
                  SET email = '$_new_email', username = '$_new_username', password = '$_new_pwd', birthday = '$_new_birthday', birthdayModified = 1
                  WHERE email = '$email' AND (birthday = '$new_birthday' OR birthdayModified = 0)";
        return mysqli_query($this->connection, $query);
    }

    public function deleteAccount($email) {
        $query = "DELETE FROM UTENTE WHERE email = '$email'";
        return mysqli_query($this->connection, $query);
    }
}

?>
