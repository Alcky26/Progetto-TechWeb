<?php

namespace DB;

class DBAccess {

    private const HOST_DB = "localhost";
    private const USERNAME = "mvignaga";
    private const PASSWORD = "ohthohXie5aichah";
    private const DATABASE_NAME = "mvignaga";

    private $connection;

    public function openDBConnection() {
        $this->connection = mysqli_connect(DBAccess::HOST_DB,
                                           DBAccess::USERNAME,
                                           DBAccess::PASSWORD,
                                           DBAccess::DATABASE_NAME);

        if(!$this->connection) {
            return false;
        } else {
            mysqli_query($this->connection, "SET lc_time_names = 'it_IT'");
            return true;
        }
    }

    public function closeDBConnection() {
        if($this->connection)
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

        if(mysqli_num_rows($queryResult) == 1) {
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

}

?>