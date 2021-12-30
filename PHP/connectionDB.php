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
    public function checkUserAndPassword($username, $password) {
        $checkUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT *
                FROM UTENTE
                WHERE BINARY email = '$checkUsername' AND Password = '$password'";

        $queryResult = mysqli_query($this->connection, $sql);

        if (mysqli_num_rows($queryResult) == 1) {
            $user = mysqli_fetch_assoc($queryResult);
            return array(
                "isValid" => true,
                "email" => $user["email"],
            );
        }
        return array(
            "isValid" => false,
            "email" => null,
        );
    }

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
        $query = "SELECT nome_ingr, allergene
                  FROM INGREDIENTE JOIN COMPOSIZIONE ON INGREDIENTE.nome = COMPOSIZIONE.nome_ingr
                  WHERE COMPOSIZIONE.nome = '$pizza'";
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
}

?>
