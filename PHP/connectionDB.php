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

    /*
        LOGIN
    */
    public function checkLogin($username, $password) {
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

    /*
        ADMINISTRATOR
    */
        public function getIngredienti()
        {
            $sql = "SELECT `INGREDIENTE`.`nome`,`INGREDIENTE`.`id_ingrediente`  FROM `INGREDIENTE` ORDER BY `INGREDIENTE`.`id_ingrediente` ASC";
            return $this->execQuery($sql);
        }
            /*
                AGGIUNGI
            */
            public function addPizza($nome,$categoria, $prezzo, $descrizione, $idingrediente)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtIdIngrediente = mysqli_real_escape_string($this->connection, $idingrediente);

                $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                $sql2 = "INSERT INTO `PIZZA` (`nome`, `categoria`) VALUES ('$txtNome', '$txtCategoria');";
                
                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result == 1) {
                    mysqli_query($this->connection, $sql2);
                    $result=mysqli_affected_rows($this->connection);
                    if($result == 1) {
                        $txtId = explode("-", $txtIdIngrediente);
                        $sql3 = array();
                        for ($i = 0; $i < count($txtId); $i++) {
                            array_push($sql3, "INSERT INTO `COMPOSIZIONE` (`id_ingrediente`, `nome`) VALUES ('$txtId[$i]', '$txtNome')");
                        }
                        $aff_rows = 0;
                        foreach($sql3 as $current_sql) {
                            $insert = mysqli_query($this->connection, $current_sql); 
                            $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                        }
                        if($aff_rows == count($txtId)) {
                            return true;
                        }
                    }
                }
                $sqlcount = "SELECT count(*) as conta FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome`='$txtNome'";
                $result = mysqli_query($this->connection, $sqlcount);

                if (mysqli_num_rows($result) == 1) {
                    $count = mysqli_fetch_assoc($result);
                    $conta=$count["conta"];
                }
                $sql4 = array();
                array_push($sql4, "DELETE FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome` = '$txtNome'");
                array_push($sql4, "DELETE FROM `PIZZA` WHERE `PIZZA`.`nome`= '$txtNome'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtNome'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                }
                return false;
            }
            /*
                FINE AGGIUNGI
            */

            /*
                ELIMINA
            */
            public function getPizze() {
                $query = "SELECT * FROM `PIZZA`";
                return $this->execQuery($query);
            }

            public function delPizza($pizza) {
                $txtpizza = mysqli_real_escape_string($this->connection, $pizza);
                $sqlcount = "SELECT count(*) as conta FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome`='$txtpizza'";
                $result = mysqli_query($this->connection, $sqlcount);

                if (mysqli_num_rows($result) == 1) {
                    $count = mysqli_fetch_assoc($result);
                    $conta=$count["conta"];
                }
                $sql4 = array();
                array_push($sql4, "DELETE FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome` = '$txtpizza'");
                array_push($sql4, "DELETE FROM `PIZZA` WHERE `PIZZA`.`nome`= '$txtpizza'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtpizza'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == ($conta+2)) {
                    return true;
                }
                else {
                    return false;
                }
            }
            /*
                FINE ELIMINA
            */

            /*
                MODIFICA
            */
            public function selectPizza($nome)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $sql5 = "SELECT `PIZZA`.`nome`,`PIZZA`.`categoria`,`ELEMENTO_LISTINO`.`prezzo`,`ELEMENTO_LISTINO`.`descrizione`
                        FROM `PIZZA` JOIN `ELEMENTO_LISTINO` on `PIZZA`.`nome`=`ELEMENTO_LISTINO`.`nome` 
                        WHERE `PIZZA`.`nome`='$txtNome'";

                $sql6 = "SELECT `INGREDIENTE`.`id_ingrediente`,`INGREDIENTE`.`nome`
                        FROM `PIZZA` JOIN `COMPOSIZIONE` on `PIZZA`.`nome`=`COMPOSIZIONE`.`nome` JOIN `INGREDIENTE` on `COMPOSIZIONE`.`id_ingrediente`=`INGREDIENTE`.`id_ingrediente`
                        WHERE `PIZZA`.`nome`='$txtNome'";
                
                $pizza = $this->execQuery($sql5);
                $result2 = mysqli_query($this->connection, $sql6);
                while ($row = mysqli_fetch_assoc($result2)) {
                    array_push($pizza, $row);
                }
                return $pizza;
            }

            public function updatePizza($nome,$categoria, $prezzo, $descrizione, $idIngredienti, $nomevecchio)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtIdIngredienti = mysqli_real_escape_string($this->connection,$idIngredienti);
                $txtOldName = mysqli_real_escape_string($this->connection, $nomevecchio);

                $stringaIngredienti = explode("-", $txtIdIngredienti);
                //prima cancello quelle vecchie
                $sqlcount = "SELECT count(*) as conta FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome`='$txtOldName'";
                $result = mysqli_query($this->connection, $sqlcount);

                if (mysqli_num_rows($result) == 1) {
                    $count = mysqli_fetch_assoc($result);
                    $conta=$count["conta"];
                }
                $sql4 = array();
                array_push($sql4, "DELETE FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome` = '$txtOldName'");
                array_push($sql4, "DELETE FROM `PIZZA` WHERE `PIZZA`.`nome`= '$txtOldName'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtOldName'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == ($conta+2)) {
                    $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                    $sql2 ="INSERT INTO `PIZZA` (`nome`, `categoria`) VALUES ('$txtNome', '$txtCategoria');";
                    
                    mysqli_query($this->connection, $sql);
                    $result=mysqli_affected_rows($this->connection);
                    if ($result == 1) {
                        mysqli_query($this->connection, $sql2);
                        $result=mysqli_affected_rows($this->connection);
                        if($result == 1) {
                            $sql3 = array();
                            $aff_rows = 0;
                            foreach($stringaIngredienti as $ingred) {
                                array_push($sql3, "INSERT INTO `COMPOSIZIONE` (`id_ingrediente`, `nome`) VALUES ('$ingred', '$txtNome')");
                            }
                            foreach($sql3 as $current_sql) {
                                $update = mysqli_query($this->connection, $current_sql); 
                                $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                            }
                            if($aff_rows == count($stringaIngredienti)) {
                                return true;
                            }
                        }
                    }
                }
                //////////////////////////////////////// CHE ROLL BACK FARE ????????????????
            }
            /*
                FINE MODIFICA
            */
    /*
            FINE ADMINISTRATOR
    */

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

    public function getBonus($email, $dataScadenza, $minValore, $maxValore) {
        $query = "SELECT dataScadenza, valore, dataRiscatto, codiceBonus, dataRiscatto
                  FROM BONUS
                  WHERE email = '$email' AND dataScadenza <= '$dataScadenza' AND valore >= '$minValore' AND valore <= '$maxValore'
                  ORDER BY dataScadenza DESC";
        return $this->execQuery($query);
    }

    public function getPrenotazioni($email, $periodo, $minPersone, $maxPersone) {
        $query = "SELECT dataOra, numero, persone
                  FROM PRENOTAZIONE
                  WHERE email = '$email' AND dataOra >= '$periodo' AND persone >= '$minPersone' AND persone <= '$maxPersone'
                  ORDER BY dataOra DESC";
        return $this->execQuery($query);
    }

    public function getAcquisti($email, $data, $minSpesa, $maxSpesa) {
        $query = "SELECT ORDINAZIONE.email, ORDINAZIONE.dataOra, ACQUISTO.quantita * ELEMENTO_LISTINO.prezzo AS spesa
                  FROM ELEMENTO_LISTINO JOIN ACQUISTO ON ELEMENTO_LISTINO.nome = ACQUISTO.nome
                  JOIN ORDINAZIONE ON ACQUISTO.dataOra = ORDINAZIONE.dataOra AND ACQUISTO.email = ORDINAZIONE.email
                  WHERE ORDINAZIONE.email = '$email' AND ORDINAZIONE.dataOra > '$data'
                  HAVING spesa >= '$minSpesa' AND spesa <= '$maxSpesa'
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
        $_new_birthday = $new_birthday;
        $query = "UPDATE UTENTE
                  SET email = '$_new_email', username = '$_new_username', password = '$_new_pwd'
                  WHERE email = '$email'";
        $result1 = mysqli_query($this->connection, $query);;
        $result2 = 1;
        if (substr($this->getUserInfo($_SESSION["email"])[0]["birthday"], 0, 10) != $_new_birthday) {
            $query = "UPDATE UTENTE
                      SET birthday = '$_new_birthday', birthdayModified = 1
                      WHERE email = '$_new_email' AND birthdayModified = 0";
            mysqli_query($this->connection, $query);
            $result2 = mysqli_affected_rows($this->connection);
        }
        if($result1 && $result2)
            return "Modifiche salvate.";
        else if (!$result1)
            return "Errore nell'inserimento dei dati.";
        else
            return "ATTENZIONE: non è possibile modificare il giorno del compleanno più di una volta.";
    }

    public function deleteAccount($email) {
        $query = "DELETE FROM UTENTE WHERE email = '$email'";
        return mysqli_query($this->connection, $query);
    }

    public function getTavoli($dataora) {
      $tavoliDisp = "SELECT TAVOLO.numero FROM TAVOLO WHERE TAVOLO.numero NOT IN (
        SELECT TAVOLO.numero FROM TAVOLO INNER JOIN PRENOTAZIONE ON TAVOLO.numero = PRENOTAZIONE.numero
        WHERE TIMEDIFF ('$dataora',dataOra) >= '02:00:00')
        LIMIT 1";

      return $this->execQuery($tavoliDisp);
    }

    public function insertPrenotazioni ($nPersone, $dataOra, $nTavolo,$email){
      $query = "INSERT INTO `PRENOTAZIONE` (`persone`,`dataOra`,`numero`,`email`)
                VALUES ('$nPersone','$dataOra','$nTavolo','$email')";
      $risultato = mysqli_query($this->connection, $query) or die (mysqli_error($this->connection));
      if(mysqli_affected_rows($this->connection) > 0) {
        return true;
      } else {
        return false;
      }
    }

    public function insertOrdinazioni ($dataora, $email){
      $query = "INSERT INTO `ORDINAZIONE` (`dataOra`,`email`)
                VALUES ('$dataora','$email')";
      $risultato = mysqli_query($this->connection, $query);
      if(mysqli_affected_rows($this->connection) > 0) {
        return true;
      } else {
        return false;
      }
    }

    public function insertAcquisto ($quantita,$nome,$dataora,$email){
      $query = "INSERT INTO `ACQUISTO` (`quantita`,`nome`,`dataOra`,`email`)
                VALUES ('$quantita','$nome','$dataora','$email')";
      $risultato = mysqli_query($this->connection, $query);
      if(mysqli_affected_rows($this->connection) > 0) {
        return true;
      } else {
        return false;
      }
    }

    public function useBonus($codice,$email,$dataR){
      $query = "UPDATE BONUS
                SET dataRiscatto = '$dataR'
                WHERE codiceBonus = '$codice', email = '$email'";
      $risultato = mysqli_query($this->connection, $query);
      if(mysqli_affected_rows($this->connection) > 0) {
        return true;
      } else {
          return false;
        }
    }
}

?>
