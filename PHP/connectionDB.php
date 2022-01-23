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

            public function addBevanda($nome,$categoria, $gradi, $descrizione, $prezzo)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtGradi = mysqli_real_escape_string($this->connection, $gradi);

                $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                $sql2 = "INSERT INTO `BEVANDA` (`nome`, `categoria` , `gradiAlcolici`) VALUES ('$txtNome', '$txtCategoria', '$txtGradi');";
                
                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result == 1) {
                    mysqli_query($this->connection, $sql2);
                    $result=mysqli_affected_rows($this->connection);
                    if($result == 1) {
                        return true;
                    }
                }
                $sql4 = array();
                array_push($sql4, "DELETE FROM `BEVANDA` WHERE `BEVANDA`.`nome`= '$txtNome'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtNome'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                }
                return false;
            }

            public function addDolce($nome, $descrizione, $prezzo)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);

                $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                $sql2 = "INSERT INTO `DOLCE` (`nome`) VALUES ('$txtNome');";
                
                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result == 1) {
                    mysqli_query($this->connection, $sql2);
                    $result=mysqli_affected_rows($this->connection);
                    if($result == 1) {
                        return true;
                    }
                }
                $sql4 = array();
                array_push($sql4, "DELETE FROM `DOLCE` WHERE `DOLCE`.`nome`= '$txtNome'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtNome'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                }
                return false;
            }

            public function addIngrediente($nome, $categoria)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);

                $sql2 = "INSERT INTO `INGREDIENTE` (`nome`, `allergene`) VALUES ('$txtNome', '$txtCategoria')";
                
                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result == 1) {
                    mysqli_query($this->connection, $sql2);
                    $result=mysqli_affected_rows($this->connection);
                    if($result == 1) {
                        return true;
                    }
                }
                $sql4 = array();
                array_push($sql4, "DELETE FROM `INGREDIENTE` WHERE `INGREDIENTE`.`nome`= '$txtNome'");
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

            public function getListBevande() {
                $query = "SELECT * FROM `BEVANDA`";
                return $this->execQuery($query);
            }

            public function delBevanda($bevanda) {
                $txtbevanda = mysqli_real_escape_string($this->connection, $bevanda);
                $sql4 = array();
                array_push($sql4, "DELETE FROM `PIZZA` WHERE `PIZZA`.`nome`= '$txtbevanda'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtbevanda'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == 2) {
                    return true;
                }
                else {
                    return false;
                }
            }

            public function getListDolci() {
                $query = "SELECT * FROM `DOLCE`";
                return $this->execQuery($query);
            }

            public function delDolce($dolce) {
                $txtdolce = mysqli_real_escape_string($this->connection, $dolce);
                $sql4 = array();
                array_push($sql4, "DELETE FROM `DOLCE` WHERE `DOLCE`.`nome`= '$txtdolce'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtdolce'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == 2) {
                    return true;
                }
                else {
                    return false;
                }
            }

            public function delIngrediente($ingrediente) {
                $txtingrediente = mysqli_real_escape_string($this->connection, $ingrediente);
                $sql4 = array();
                array_push($sql4, "DELETE FROM `INGREDIENTE` WHERE `INGREDIENTE`.`nome`= '$txtingrediente'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtdolce'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == 2) {
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

            public function selectBevanda($nome)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $sql5 = "SELECT `BEVANDA`.`nome`,`BEVANDA`.`categoria`,`BEVANDA`.`gradiAlcolici` ,`ELEMENTO_LISTINO`.`prezzo`,`ELEMENTO_LISTINO`.`descrizione`
                        FROM `BEVANDA` JOIN `ELEMENTO_LISTINO` on `BEVANDA`.`nome`=`ELEMENTO_LISTINO`.`nome` 
                        WHERE `BEVANDA`.`nome`='$txtNome'";
                
                $bevanda = $this->execQuery($sql5);
                return $bevanda;
            }

            public function selectDolce($nome)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $sql5 = "SELECT `DOLCE`.`nome`,`ELEMENTO_LISTINO`.`prezzo`,`ELEMENTO_LISTINO`.`descrizione`
                        FROM `DOLCE` JOIN `ELEMENTO_LISTINO` on `DOLCE`.`nome`=`ELEMENTO_LISTINO`.`nome` 
                        WHERE `DOLCE`.`nome`='$txtNome'";
                
                $dolce = $this->execQuery($sql5);
                return $dolce;
            }

            public function selectIngrediente($id)
            {
                $txtId = mysqli_real_escape_string($this->connection, $id);
                $sql5 = "SELECT `INGREDIENTE`.`nome`,`INGREDIENTE`.`allergene`,`INGREDIENTE`.`id_ingrediente`
                        FROM `INGREDIENTE`
                        WHERE `INGREDIENTE`.`id_ingrediente`='$txtId'";
                
                $dolce = $this->execQuery($sql5);
                return $dolce;
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

            public function updateBevanda($nome,$categoria, $prezzo, $descrizione, $gradialcolici, $nomevecchio)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtGradiAlcolici = (float)$gradialcolici;
                $txtOldName = mysqli_real_escape_string($this->connection, $nomevecchio);

                
                $sql4 = array();
                array_push($sql4, "DELETE FROM `BEVANDA` WHERE `BEVANDA`.`nome`= '$txtOldName'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtOldName'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == 2) {
                    $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                    $sql2 ="INSERT INTO `BEVANDA` (`nome`, `categoria`, `gradiAlcolici`) VALUES ('$txtNome', '$txtCategoria', '$txtGradiAlcolici');";
                    
                    mysqli_query($this->connection, $sql);
                    $result=mysqli_affected_rows($this->connection);
                    if ($result == 1) {
                        mysqli_query($this->connection, $sql2);
                        $result=mysqli_affected_rows($this->connection);
                        if($result == 1) {
                            return true;
                        }
                    }
                }
                //////////////////////////////////////// CHE ROLL BACK FARE ????????????????
            }
            
            public function updateDolce($nome, $prezzo, $descrizione, $nomevecchio)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtOldName = mysqli_real_escape_string($this->connection, $nomevecchio);

                $sql4 = array();
                array_push($sql4, "DELETE FROM `BEVANDA` WHERE `BEVANDA`.`nome`= '$txtOldName'");
                array_push($sql4, "DELETE FROM `ELEMENTO_LISTINO` WHERE `ELEMENTO_LISTINO`.`nome`= '$txtOldName'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql); 
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == 2) {
                    $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                    $sql2 ="INSERT INTO `BEVANDA` (`nome`) VALUES ('$txtNome');";
                    
                    mysqli_query($this->connection, $sql);
                    $result=mysqli_affected_rows($this->connection);
                    if ($result == 1) {
                        mysqli_query($this->connection, $sql2);
                        $result=mysqli_affected_rows($this->connection);
                        if($result == 1) {
                            return true;
                        }
                    }
                }
                //////////////////////////////////////// CHE ROLL BACK FARE ????????????????
            }
            public function updateIngrediente($nomeingred, $categoriaallergene, $idvecchio)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nomeingred);
                $txtAllergene = mysqli_real_escape_string($this->connection, $categoriaallergene);
                $txtOldId = mysqli_real_escape_string($this->connection, $idvecchio);

                $sql = "UPDATE `INGREDIENTE` SET `nome` = '$txtNome', `allergene` = '$txtAllergene' WHERE `INGREDIENTE`.`id_ingrediente` = '$txtOldId'";
                
                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result == 1) {
                    return true;
                }
                else
                {
                    return false;
                }
                
                //////////////////////////////////////// CHE ROLL BACK FARE ???????????????? PROBLEMA DEL FATTO CHE SE CAMBIO NOME, CAMBIO NOME ANCHE ALLINGREDIENTE SU COMPOSIZIONE
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
