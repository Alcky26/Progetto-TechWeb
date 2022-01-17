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
            /*
                AGGIUNGI
            */
            public function addPizza($nome,$categoria, $prezzo, $descrizione)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);

                $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                $sql2 ="INSERT INTO `PIZZA` (`nome`, `categoria`) VALUES ('$txtNome', '$txtCategoria');";
                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result == 1) {
                    mysqli_query($this->connection, $sql2);
                    $result=mysqli_affected_rows($this->connection);
                    if($result == 1) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }

                //manca ingredienti
            }
            /*
                FINE AGGIUNGI
            */
            /*
                MODIFICA
            */
            public function FillTemporaneo()
            {
                $updateFill = array("", "", "", "","");
                $sql = "SELECT `ELEMENTO_LISTINO`.`nome`,`PIZZA`.`categoria`,`ELEMENTO_LISTINO`.`prezzo`,`ELEMENTO_LISTINO`.`descrizione`
                FROM `ELEMENTO_LISTINO` join `PIZZA` on `ELEMENTO_LISTINO`.`nome`=`PIZZA`.`nome`
                WHERE `ELEMENTO_LISTINO`.`nome`=\"pizza test\"";
                $queryResult=mysqli_query($this->connection, $sql);
                if ($queryResult && mysqli_num_rows($queryResult) > 0) {
                    $row = mysqli_fetch_assoc($queryResult);
                        $updateFill[0]=$row['nome'];
                        $updateFill[0]=$row['categoria'];
                        $updateFill[0]=$row['prezzo'];
                        $updateFill[0]=$row['descrizione'];
                }
                var_dump($updateFill);
                die;
                return $updateFill;
            }

            public function updatePizza($nome,$categoria, $prezzo, $descrizione)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);

                $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                $sql2 ="INSERT INTO `PIZZA` (`nome`, `categoria`) VALUES ('$txtNome', '$txtCategoria');";
                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result == 1) {
                    mysqli_query($this->connection, $sql2);
                    $result=mysqli_affected_rows($this->connection);
                    if($result == 1) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }

                //manca ingredienti
            }
            /*
                FINE MODIFICA
            */
    /*
            FINE ADMINISTRATOR
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
        $_new_birthday = mysqli_real_escape_string($this->connection, $new_birthday);
        $query = "UPDATE UTENTE
                  SET email = '$_new_email', username = '$_new_username', password = '$_new_pwd'
                  WHERE email = '$email'";
        if (mysqli_query($this->connection, $query)) {
            $query = "UPDATE UTENTE
                      SET birthday = '$_new_birthday', birthdayModified = 1
                      WHERE email = '$_new_email' AND birthdayModified = 0";
            return mysqli_query($this->connection, $query);
        }
        return false;
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
