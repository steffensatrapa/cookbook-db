<?php

class CrTag {

    private $id = -1;
    private $recipeId;
    private $description;
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

    function __construct3($recipeId, $description, $sortIndex) {
        $this->recipeId = $recipeId;
        $this->description = $description;
        $this->sortIndex = $sortIndex;
    }

    function saveToDatabase() {

        if ($this->id < 0) {
            $this->id = CrDatabase::query(
                            "INSERT INTO tag 
                                (
                                    recipeId,
                                    description,
                                    sortIndex
                                ) 
                            VALUES 
                                (
                                    :recipeId,
                                    :description,
                                    :sortIndex
                                )"
                            , array(
                        ':recipeId' => $this->recipeId,
                        ':sortIndex' => $this->sortIndex,
                        ':description' => $this->description));
        } else {

            CrDatabase::query(
                    "UPDATE tag SET 
                                recipeId=:recipeId,
                                sortIndex=:sortIndex,
                                description=:description
                            WHERE id=:id"
                    , array(
                ':id' => $this->id,
                ':recipeId' => $this->recipeId,
                ':sortIndex' => $this->sortIndex,
                ':description' => $this->description));
        }
    }

    private static function getObjectFromDatabaseResult($row) {
        if (array_key_exists('id', $row)) {

            $tag = new CrTag();
            $tag->id = $row['id'];
            $tag->recipeId = $row['recipeId'];
            $tag->description = htmlentities($row['description']);
            $tag->sortIndex = $row['sortIndex'];


            return $tag;
        } else {
            return false;
        }
    }

    public static function loadFromDatabaseByRecipeId($recipeId) {

        $rows = CrDatabase::queryFetch(
                        "SELECT * FROM tag WHERE recipeId=:recipeId order by sortIndex"
                        , array(
                    ':recipeId' => $recipeId)
        );

        if (count($rows) > 0) {
            $tags = array();
            foreach ($rows as $row) {
                array_push($tags, CrTag::getObjectFromDatabaseResult($row));
            }

            return $tags;
        } else {
            return false;
        }
    }

    public static function parseTags($text, $recipe) {
        $tags = array();

        $n = 1;
        foreach (preg_split("/((\r?\n)|(\r\n?)|[ \t,;|])/", $text) as $tagStr) {
            if (trim($tagStr) != "") {
                $tag = new CrTag($recipe->getId(), $tagStr, $n);
                array_push($tags, $tag);
                $n++;
            }
        }

        return $tags;
    }

    public static function createDatabaseTable() {
        CrDatabase::query("CREATE TABLE IF NOT EXISTS tag (
                                id           INT NOT NULL AUTO_INCREMENT,
                                recipeId     INT NOT NULL,
                                description  VARCHAR(128) NOT NULL,
                                sortIndex    INT NOT NULL,
                                FOREIGN KEY (recipeId) REFERENCES recipe(id),
                                UNIQUE (recipeId, description),
                                FULLTEXT (description),
                                PRIMARY KEY (id)
                            )  CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    }

    function __toString() {
        return $this->description;
    }

}
