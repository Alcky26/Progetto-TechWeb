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

    private function execQuery($query) {
        $queryResult = mysqli_query($this->connection, $query) or die("Errore: ".mysqli_error($this->connection));
        $result = array();

        if ($queryResult) {
            while ($row = mysqli_fetch_assoc($queryResult)) {
                array_push($result, $row);
            }
        }
        return $result;
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
        public function contaIngredienti($nome)
        {
            $txtNome = mysqli_real_escape_string($this->connection, $nome);
            $sql = "SELECT count(*) as conta FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome`='$txtNome'";
            return $this->execQuery($sql);
        }

        public function getIngredienti()
        {
            $sql = "SELECT `INGREDIENTE`.`nome`,`INGREDIENTE`.`id_ingrediente`  FROM `INGREDIENTE` ORDER BY `INGREDIENTE`.`id_ingrediente` ASC";
            return $this->execQuery($sql);
        }

        public function getIngredientiPizza($nome)
        {
            $txtNome = mysqli_real_escape_string($this->connection, $nome);
            $sql = "SELECT `INGREDIENTE`.`nome`,`INGREDIENTE`.`id_ingrediente`  FROM `INGREDIENTE` JOIN `COMPOSIZIONE` on `INGREDIENTE`.`id_ingrediente`=`COMPOSIZIONE`.`id_ingrediente`
            WHERE `COMPOSIZIONE`.`nome` = '$txtNome'
            ORDER BY `INGREDIENTE`.`id_ingrediente` ASC";
            return $this->execQuery($sql);
        }

            /*
                DISABILITA
            */
            public function searchPizza($nome){
                $sql = "SELECT `PIZZA`.`nome` FROM `PIZZA` WHERE `PIZZA`.`nome` = '$nome';";
                return $this->execQuery($sql);
            }
            public function searchBevanda($nome){
                $sql = "SELECT `BEVANDA`.`nome` FROM `BEVANDA` WHERE `BEVANDA`.`nome` = '$nome';";
                return $this->execQuery($sql);
            }
            public function searchDolce($nome){
                $sql = "SELECT `DOLCE`.`nome` FROM `DOLCE` WHERE `DOLCE`.`nome` = '$nome';";
                return $this->execQuery($sql);
            }
            public function disabilitaIngred($nome, $nuovo, $olddisponibile){
                $sql = "UPDATE `INGREDIENTE` SET `disponibile` = '$nuovo' WHERE `INGREDIENTE`.`nome` = '$nome' AND `INGREDIENTE`.`disponibile` = '$olddisponibile';";
                $result = mysqli_query($this->connection, $sql);
                return mysqli_affected_rows($this->connection);
            }
            public function disabilitaPizza($nome, $nuovo, $olddisponibile){
                $sql = "UPDATE `PIZZA` SET `disponibile` = '$nuovo' WHERE `PIZZA`.`nome` = '$nome' AND `PIZZA`.`disponibile` = '$olddisponibile';";
                $result = mysqli_query($this->connection, $sql);
                return mysqli_affected_rows($this->connection);
            }
            public function disabilitaBevanda($nome, $nuovo, $olddisponibile){
                $sql = "UPDATE `BEVANDA` SET `disponibile` = '$nuovo' WHERE `BEVANDA`.`nome` = '$nome' AND `BEVANDA`.`disponibile` = '$olddisponibile';";
                $result = mysqli_query($this->connection, $sql);
                return mysqli_affected_rows($this->connection);
            }
            public function disabilitaDolce($nome, $nuovo, $olddisponibile){
                $sql = "UPDATE `DOLCE` SET `disponibile` = '$nuovo' WHERE `DOLCE`.`nome` = '$nome' AND `DOLCE`.`disponibile` = '$olddisponibile';";
                $result = mysqli_query($this->connection, $sql);
                return mysqli_affected_rows($this->connection);
            }
            public function getItems(){
                $sql = "SELECT `ELEMENTO_LISTINO`.`nome`, `PIZZA`.`disponibile`
                FROM `ELEMENTO_LISTINO` JOIN `PIZZA` on `ELEMENTO_LISTINO`.`nome` = `PIZZA`.`nome`
                WHERE `ELEMENTO_LISTINO`.`nome` NOT IN (SELECT `ACQUISTO`.`nome` FROM `ACQUISTO`)
                UNION
                SELECT `ELEMENTO_LISTINO`.`nome`, `BEVANDA`.`disponibile`
                FROM `ELEMENTO_LISTINO` JOIN `BEVANDA` on `ELEMENTO_LISTINO`.`nome` = `BEVANDA`.`nome`
                WHERE `ELEMENTO_LISTINO`.`nome` NOT IN (SELECT `ACQUISTO`.`nome` FROM `ACQUISTO`)
                UNION
                SELECT `ELEMENTO_LISTINO`.`nome`, `DOLCE`.`disponibile`
                FROM `ELEMENTO_LISTINO` JOIN `DOLCE` on `ELEMENTO_LISTINO`.`nome` = `DOLCE`.`nome`
                WHERE `ELEMENTO_LISTINO`.`nome` NOT IN (SELECT `ACQUISTO`.`nome` FROM `ACQUISTO`)";
                return $this->execQuery($sql);
            }
            public function getItemsIngred(){
                $sql = "SELECT `INGREDIENTE`.`nome`, `INGREDIENTE`.`disponibile`
                FROM `INGREDIENTE`
                WHERE `INGREDIENTE`.`id_ingrediente` NOT IN (SELECT `COMPOSIZIONE`.`id_ingrediente`
                                                             FROM `COMPOSIZIONE` JOIN `INGREDIENTE` on `INGREDIENTE`.`id_ingrediente`=`COMPOSIZIONE`.`id_ingrediente`)";
                return $this->execQuery($sql);
            }

            /*
                FINE DISABILITA
            */
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
                return false;
            }

            public function addBevanda($nome,$categoria, $gradi, $descrizione, $prezzo)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtGradi = (float)$gradi;

                $sql = "INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES ('$txtNome', '$txtPrezzo', '$txtDescrizione');";
                $sql2 = "INSERT INTO `BEVANDA` (`nome`, `categoria` , `gradiAlcolici`) VALUES ('$txtNome', '$txtCategoria', '$txtGradi');";

                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if ($result) {
                    mysqli_query($this->connection, $sql2);
                    $result=mysqli_affected_rows($this->connection);
                    if($result) {
                        return true;
                    }
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
                return false;
            }

            public function addIngrediente($nome, $categoria)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);

                $sql1 = "SELECT * FROM `INGREDIENTE` WHERE `INGREDIENTE`.`nome`='$txtNome'";
                mysqli_query($this->connection, $sql1);
                $result=mysqli_affected_rows($this->connection);
                if($result == 1) {
                    return false;
                }
                $sql2 = "INSERT INTO `INGREDIENTE` (`nome`, `allergene`) VALUES ('$txtNome', '$txtCategoria')";
                mysqli_query($this->connection, $sql2);
                $result=mysqli_affected_rows($this->connection);
                if($result == 1) {
                    return true;
                }
                return false;
            }
            /*
                FINE AGGIUNGI
            */

            /*
                ELIMINA
            */
            public function getPizzeDelete() {
                $query = "SELECT * FROM `PIZZA` WHERE `PIZZA`.`disponibile` = FALSE";
                return $this->execQuery($query);
            }
            public function getBevandeDelete() {
                $query = "SELECT * FROM `BEVANDA` WHERE `BEVANDA`.`disponibile` = FALSE";
                return $this->execQuery($query);
            }
            public function getDolciDelete() {
                $query = "SELECT * FROM `DOLCE` WHERE `DOLCE`.`disponibile` = FALSE";
                return $this->execQuery($query);
            }
            public function getIngredientiDelete() {
                $query = "SELECT * FROM `INGREDIENTE` WHERE `INGREDIENTE`.`disponibile` = FALSE";
                return $this->execQuery($query);
            }


            public function getPizze() {
                $query = "SELECT * FROM `PIZZA`";
                return $this->execQuery($query);
            }
            public function getBevandeModifica() {
                $query = "SELECT * FROM `BEVANDA`";
                return $this->execQuery($query);
            }
            public function getDolciModifica() {
                $query = "SELECT * FROM `DOLCE`";
                return $this->execQuery($query);
            }
            public function getIngredientiModifica() {
                $query = "SELECT * FROM `INGREDIENTE`";
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
                array_push($sql4, "DELETE FROM `BEVANDA` WHERE `BEVANDA`.`nome`= '$txtbevanda'");
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
                array_push($sql4, "DELETE FROM `INGREDIENTE` WHERE `INGREDIENTE`.`id_ingrediente`= '$txtingrediente'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql);
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == 1) {
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

            public function updatePizza($nome,$categoria, $prezzo, $descrizione, $idIngredienti)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtIdIngredienti = mysqli_real_escape_string($this->connection,$idIngredienti);

                $stringaIngredienti = explode("-", $txtIdIngredienti);
                //prima cancello quelle vecchie
                $sqlcount = "SELECT count(*) as conta FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome`='$txtNome'";
                $result = mysqli_query($this->connection, $sqlcount);

                if (mysqli_num_rows($result) == 1) {
                    $count = mysqli_fetch_assoc($result);
                    $conta=$count["conta"];
                }
                $sql4 = array();
                array_push($sql4, "DELETE FROM `COMPOSIZIONE` WHERE `COMPOSIZIONE`.`nome` = '$txtNome'");
                $aff_rows = 0;
                foreach($sql4 as $current_sql) {
                    $delete = mysqli_query($this->connection, $current_sql);
                    $aff_rows = $aff_rows + mysqli_affected_rows($this->connection);
                }
                if($aff_rows == $conta) {
                    $sql = "UPDATE `ELEMENTO_LISTINO` SET `prezzo` = '$txtPrezzo', `descrizione` = '$txtDescrizione' WHERE `ELEMENTO_LISTINO`.`nome` = '$txtNome'";
                    $sql2 ="UPDATE `PIZZA` SET `categoria` = '$txtCategoria' WHERE `PIZZA`.`nome` = '$txtNome';";
                    mysqli_query($this->connection, $sql);
                    mysqli_query($this->connection, $sql2);
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
                    else{
                        return false;
                    }
                }
            }

            public function updateBevanda($nome,$categoria, $prezzo, $descrizione, $gradialcolici)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtCategoria = mysqli_real_escape_string($this->connection, $categoria);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);
                $txtGradiAlcolici = mysqli_real_escape_string($this->connection, $gradialcolici);
                $sql = "UPDATE `ELEMENTO_LISTINO` SET `prezzo` = '$txtPrezzo', `descrizione` = '$txtDescrizione' WHERE `ELEMENTO_LISTINO`.`nome` = '$txtNome'";
                $sql2 ="UPDATE `BEVANDA` SET `categoria` = '$txtCategoria', `gradiAlcolici` = '$txtGradiAlcolici' WHERE `BEVANDA`.`nome` = '$txtNome'";
                mysqli_query($this->connection, $sql);
                mysqli_query($this->connection, $sql2);
                $result=mysqli_affected_rows($this->connection);
                if($result) {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            public function updateDolce($nome, $prezzo, $descrizione)
            {
                $txtNome = mysqli_real_escape_string($this->connection, $nome);
                $txtPrezzo = (float)$prezzo;
                $txtDescrizione = mysqli_real_escape_string($this->connection, $descrizione);

                $sql = "UPDATE `ELEMENTO_LISTINO` SET `prezzo` = '$txtPrezzo', `descrizione` = '$txtDescrizione' WHERE `ELEMENTO_LISTINO`.`nome` = '$txtNome';";

                mysqli_query($this->connection, $sql);
                $result=mysqli_affected_rows($this->connection);
                if($result) {
                    return true;
                }
                else
                {
                    return false;
                }
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
                  WHERE categoria = 'classiche'AND disponibile = 1";
        return $this->execQuery($query);
    }

    public function getSpeciali() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, descrizione
                  FROM PIZZA INNER JOIN ELEMENTO_LISTINO ON PIZZA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'speciali' AND disponibile = 1";
        return $this->execQuery($query);
    }

    public function getBianche() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, descrizione
                  FROM PIZZA INNER JOIN ELEMENTO_LISTINO ON PIZZA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'bianche' AND disponibile = 1";
        return $this->execQuery($query);
    }

    public function getCalzoni() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, descrizione
                  FROM PIZZA INNER JOIN ELEMENTO_LISTINO ON PIZZA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'calzoni' AND disponibile = 1";
        return $this->execQuery($query);
    }

    public function getBevande() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, gradiAlcolici, descrizione
                  FROM BEVANDA INNER JOIN ELEMENTO_LISTINO ON BEVANDA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'bevande analcoliche' AND disponibile = 1";
        return $this->execQuery($query);
    }

    public function getBirre() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, gradiAlcolici, descrizione
                  FROM BEVANDA INNER JOIN ELEMENTO_LISTINO ON BEVANDA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'birre' AND disponibile = 1";
        return $this->execQuery($query);
    }

    public function getVini() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, categoria, gradiAlcolici, descrizione
                  FROM BEVANDA INNER JOIN ELEMENTO_LISTINO ON BEVANDA.nome = ELEMENTO_LISTINO.nome
                  WHERE categoria = 'vini' AND disponibile = 1";
        return $this->execQuery($query);
    }

    public function getDolci() {
        $query = "SELECT ELEMENTO_LISTINO.nome, prezzo, descrizione
                  FROM DOLCE INNER JOIN ELEMENTO_LISTINO ON DOLCE.nome = ELEMENTO_LISTINO.nome
                  WHERE disponibile = 1";
        return $this->execQuery($query);
    }

    public function getBonus($email, $dataScadenza, $minValore, $maxValore) {
        $query = "SELECT codiceBonus, dataScadenza, valore, dataRiscatto
                  FROM BONUS
                  WHERE email = '$email'
                  AND dataScadenza >= ".($dataScadenza !== NULL ? "'$dataScadenza'" : "dataScadenza")."
                  AND valore >= ".($minValore !== NULL ? "$minValore" : "valore")."
                  AND valore <= ".($maxValore !== NULL ? "$maxValore" : "valore")."
                  ORDER BY dataScadenza DESC";
        return $this->execQuery($query);
    }

    public function getPrenotazioni($email, $periodo, $persone) {
        $query = "SELECT dataOra, numero, persone
                  FROM PRENOTAZIONE
                  WHERE email = '$email'
                  AND dataOra >= ".($periodo !== NULL ? "'$periodo'" : "dataOra")."
                  AND persone = ".($persone !== NULL ? "'$persone'" : "persone")."
                  ORDER BY dataOra DESC";
        return $this->execQuery($query);
    }

    public function getAcquisti($email, $data, $spesa) {
        $query = "SELECT ORDINAZIONE.email, ORDINAZIONE.dataOra, ELEMENTO_LISTINO.nome, ACQUISTO.quantita, ELEMENTO_LISTINO.prezzo, ACQUISTO.quantita * ELEMENTO_LISTINO.prezzo AS spesa
                  FROM ELEMENTO_LISTINO JOIN ACQUISTO ON ELEMENTO_LISTINO.nome = ACQUISTO.nome
                  JOIN ORDINAZIONE ON ACQUISTO.dataOra = ORDINAZIONE.dataOra AND ACQUISTO.email = ORDINAZIONE.email
                  WHERE ORDINAZIONE.email = '$email'
                  AND ORDINAZIONE.dataOra <= ".($data !== NULL ? "'$data'" : "ORDINAZIONE.dataOra")."
                  HAVING spesa >= ".($spesa !== NULL ? "$spesa" : "spesa")."
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
        $result1 = mysqli_query($this->connection, $query);
        $result2 = true;
        if (substr($this->getUserInfo($_SESSION["email"])[0]["birthday"], 0, 10) != $_new_birthday) {
            $query = "UPDATE UTENTE
                      SET birthday = '$_new_birthday', birthdayModified = 1
                      WHERE email = '$_new_email' AND birthdayModified = 0";
            mysqli_query($this->connection, $query);
            $result2 = mysqli_affected_rows($this->connection);
        }
        return $result1 && $result2;
    }

    public function deleteAccount($email) {
        $query = "DELETE FROM UTENTE WHERE email = '$email'";
        return mysqli_query($this->connection, $query);
    }

    public function getTavoli($dataora, $nPersone) {
        $tavoliDisp = "SELECT TAVOLO.numero FROM TAVOLO WHERE TAVOLO.numero NOT IN (
                           SELECT TAVOLO.numero FROM TAVOLO INNER JOIN PRENOTAZIONE ON TAVOLO.numero = PRENOTAZIONE.numero
                           WHERE TIMEDIFF ('$dataora',dataOra) >= '02:00:00')
                       AND TAVOLO.posti >= '$nPersone'
                       ORDER BY TAVOLO.posti
                       LIMIT 1";
        return $this->execQuery($tavoliDisp);
    }

    public function insertPrenotazioni ($nPersone, $dataOra, $nTavolo,$email){
        $query = "INSERT INTO `PRENOTAZIONE` (`persone`,`dataOra`,`numero`,`email`)
                  VALUES ('$nPersone','$dataOra','$nTavolo','$email')";
        $risultato = mysqli_query($this->connection, $query);
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function insertOrdinazioni ($dataora, $email){
        $query = "INSERT INTO `ORDINAZIONE` (`dataOra`,`email`)
                  VALUES ('$dataora','$email')";
        $risultato = mysqli_query($this->connection, $query);
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function insertAcquisto ($quantita,$nome,$dataora,$email){
        $query = "INSERT INTO `ACQUISTO` (`quantita`,`nome`,`dataOra`,`email`)
                  VALUES ('$quantita','$nome','$dataora','$email')";
        $risultato = mysqli_query($this->connection, $query);
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function useBonus($bonus, $dataR) {
      $query = "UPDATE `BONUS`
                SET `dataRiscatto` = '$dataR'
                WHERE `codiceBonus` IN $bonus AND `dataScadenza` >= NOW() AND `dataRiscatto` = '0000-00-00 00:00:00'";
      $risultato = mysqli_query($this->connection, $query);
      return mysqli_affected_rows($this->connection) > 0;
    }
}

?>
