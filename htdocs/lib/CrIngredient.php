<?php

class CrIngredient {

    private $id = -1;
    private $recipeId;
    private $description;
    private $amount;
    private $unit;
    private $sortIndex;

    public function getId() {
        return $this->id;
    }

    public function getRecipeId() {
        return $this->recipeId;
    }

    public function setRecipeId($recipeId) {
        return $this->recipeId = $recipeId;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getUnit() {
        return $this->unit;
    }

    public function setUnit($unit) {
        $this->unit = $unit;
    }

    public function getSortIndex() {
        return $this->sortIndex;
    }

    public function setSortIndex($sortIndex) {
        $this->sortIndex = $sortIndex;
    }

    function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    function __construct1($recipeId) {
        $this->recipeId = $recipeId;
    }

    function __construct5($recipeId, $amount, $unit, $description, $sortIndex) {
        $this->recipeId = $recipeId;
        $this->amount = $amount;
        $this->unit = $unit;
        $this->description = $description;
        $this->sortIndex = $sortIndex;
    }

    function saveToDatabase() {

        if ($this->id < 0) {
            $this->id = CrDatabase::query(
                            "INSERT INTO ingredient 
                                (
                                    recipeId,
                                    amount,
                                    unit,
                                    description,
                                    sortIndex
                                ) 
                            VALUES 
                                (
                                    :recipeId,
                                    :amount,
                                    :unit,
                                    :description,
                                    :sortIndex
                                )"
                            , array(
                        ':recipeId' => $this->recipeId,
                        ':amount' => $this->amount,
                        ':unit' => $this->unit,
                        ':sortIndex' => $this->sortIndex,
                        ':description' => $this->description));
        } else {

            CrDatabase::query(
                    "UPDATE ingredient SET 
                                recipeId=:recipeId,
                                amount=:amount,
                                unit=:unit,
                                sortIndex=:sortIndex,
                                description=:description
                            WHERE id=:id"
                    , array(
                ':id' => $this->id,
                ':recipeId' => $this->recipeId,
                ':amount' => $this->amount,
                ':unit' => $this->unit,
                ':sortIndex' => $this->sortIndex,
                ':description' => $this->description));
        }
    }

    private static function getObjectFromDatabaseResult($row) {
        if (array_key_exists('id', $row)) {

            $ingredient = new CrIngredient();
            $ingredient->id = $row['id'];
            $ingredient->recipeId = $row['recipeId'];
            $ingredient->description = htmlentities($row['description']);
            $ingredient->amount = htmlentities($row['amount']);
            $ingredient->unit = htmlentities($row['unit']);
            $ingredient->sortIndex = $row['sortIndex'];


            return $ingredient;
        } else {
            return false;
        }
    }

    public static function loadFromDatabaseById($id) {

        $rows = CrDatabase::queryFetch(
                        "SELECT * FROM ingredient WHERE id=:id"
                        , array(
                    ':id' => $id)
        );

        if (count($rows) === 1) {
            return CrIngredient::getObjectFromDatabaseResult($rows[0]);
        } else {
            return false;
        }
    }

    public static function loadFromDatabaseByRecipeId($recipeId) {

        $rows = CrDatabase::queryFetch(
                        "SELECT * FROM ingredient WHERE recipeId=:recipeId order by sortIndex"
                        , array(
                    ':recipeId' => $recipeId)
        );

        if (count($rows) > 0) {
            $ingredients = array();
            foreach ($rows as $row) {
                array_push($ingredients, CrIngredient::getObjectFromDatabaseResult($row));
            }

            return $ingredients;
        } else {
            return false;
        }
    }

    public static function parseIngredients($text, $recipe) {
        $ingredients = array();

        $n = 1;
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $text) as $line) {
            if (trim($line) != "") {

                // Tabs zu Leerzeichen
                $line = str_replace("\t", " ", trim($line));
                // doppelte leerzeichen entfernen
                $line = preg_replace('!\s+!', ' ', $line);

                $parts = explode(" ", $line, 3);
                //preg_match_all("/[a-zA-ZäöüÄÖÜß]+|\d+/", $parts[0], $matches);
                preg_match_all("/[a-zA-ZäöüÄÖÜß]+|[\/,.½¼¾0-9]+/", $parts[0], $matches);

                $p = array();



                for ($i = 0; $i < count($matches[0]); $i++) {
                    array_push($p, $matches[0][$i]);
                }

                for ($i = 1; $i < count($parts); $i++) {
                    array_push($p, $parts[$i]);
                }


                $amount = null;
                $unit = null;
                $description = null;

                if (CrAmount::isAmount($p[0])) {
                    $amount = CrAmount::normalizeAmount($p[0]);
                    array_splice($p, 0, 1);
                }


                if (CrUnit::isUnit($p[0])) {
                    $unit = CrUnit::normalizeUnit($p[0]);
                    array_splice($p, 0, 1);
                }

                foreach ($p as $d) {
                    if ($description != null) {
                        $description .= " ";
                    }
                    $description .= $d;
                }

                $ingredient = new CrIngredient($recipe->getId(), $amount, $unit, $description, $n);
                array_push($ingredients, $ingredient);
                $n++;
            }
        }

        return $ingredients;
    }

    public static function createDatabaseTable() {
        CrDatabase::query("CREATE TABLE IF NOT EXISTS ingredient (
                                id           INT NOT NULL AUTO_INCREMENT,
                                recipeId     INT NOT NULL,
                                description  VARCHAR(128) NOT NULL,
                                amount       VARCHAR(8) NULL,
                                unit         VARCHAR(8) NULL,
                                sortIndex    INT NOT NULL,
                                FOREIGN KEY (recipeId) REFERENCES recipe(id),
                                UNIQUE (recipeId, description),
                                FULLTEXT (description),
                                PRIMARY KEY (id)
                            )  CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    }

}
