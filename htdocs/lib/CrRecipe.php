<?php

class CrRecipe {

    private $id = -1;
    private $title;
    private $description;
    private $createdAt;
    private $createdBy;
    private $updatedAt;
    private $updatedBy;
    private $deletedAt;
    private $deletedBy;
    private $ingredients = array();
    private $tags = array();

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription($lineEnding = "\n") {
        return str_replace("\n", $lineEnding, $this->description);
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * 
     * @return CrUser
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getUpdatedBy() {
        return $this->updatedBy;
    }

    public function getDeletedAt() {
        return $this->deletedAt;
    }

    public function getDeletedBy() {
        return $this->deletedBy;
    }

    public function getIngredients() {
        return $this->ingredients;
    }

    public function getIngredientsAsString($lineEnding = "\n", $nbsp = false) {
        $maxLengthAmount = 0;
        $maxLengthUnit = 0;

        foreach ($this->ingredients as $ingretient) {
            $maxLengthAmount = max(strlen($ingretient->getAmount()), $maxLengthAmount);
            $maxLengthUnit = max(strlen($ingretient->getUnit()), $maxLengthUnit);
        }

        $out = "";
        foreach ($this->ingredients as $ingretient) {
            $maxLengthAmount = max(strlen($ingretient->getAmount()), $maxLengthAmount);
            $maxLengthUnit = max(strlen($ingretient->getUnit()), $maxLengthUnit);

            $out .= str_pad(str_replace(".", ",", $ingretient->getAmount()), $maxLengthAmount, " ", STR_PAD_LEFT);
            $out .= " " . str_pad($ingretient->getUnit(), $maxLengthUnit, " ", STR_PAD_RIGHT);
            $out .= " " . $ingretient->getDescription();

            $out .= $lineEnding;
        }

        if ($nbsp) {
            $out = str_replace(" ", "&nbsp;", $out);
        }

        return $out;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getTagsAsString() {
        return implode(", ", $this->tags);
    }

    function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    function __construct3($title, $description, $createdBy) {
        $this->title = $title;
        $this->description = $description;
        $this->createdBy = $createdBy;
    }

    public function addIngredient($amount, $unit, $description) {
        array_push($this->ingredients, new CrIngredient($this->id, $amount, $unit, $description, count($this->ingredients)));
    }

    public function parseIngredients($text) {
        $ingredients = CrIngredient::parseIngredients($text, $this);
        $this->ingredients = array();
        foreach ($ingredients as $ingredient) {
            array_push($this->ingredients, $ingredient);
        }
    }

    public function addTag($description) {
        array_push($this->tags, new CrTag($this->id, $description, count($this->tags)));
    }

    public function parseTags($text) {
        $tags = CrTag::parseTags($text, $this);
        $this->tags = array();
        foreach ($tags as $tag) {
            array_push($this->tags, $tag);
        }
    }

    public function delete($deleteUser = null) {
        $this->deletedAt = $date = date("Y-m-d H:i:s");
        $this->deletedBy = $deleteUser;

        CrDatabase::query(
                "UPDATE recipe SET 
                                deletedBy=:deletedBy,
                                deletedAt=:deletedAt
                            WHERE id=:id"
                , array(
            ':deletedBy' => $this->deletedBy->getId(),
            ':deletedAt' => $this->deletedAt,
            ':id' => $this->id));
    }

    public function saveToDatabase($updateUser = null) {

        if ($this->id < 0) {
            $this->id = CrDatabase::query(
                            "INSERT INTO recipe 
                                (
                                    title,
                                    description,
                                    createdBy
                                ) 
                            VALUES 
                                (
                                    :title,
                                    :description,
                                    :createdBy
                                )"
                            , array(
                        ':title' => $this->title,
                        ':description' => $this->description,
                        ':createdBy' => $this->createdBy->getId()));

            $this->createdAt = $date = date("Y-m-d H:i:s");
        } else {

            $this->updatedAt = $date = date("Y-m-d H:i:s");
            $this->updatedBy = $updateUser;
            CrDatabase::query(
                    "UPDATE recipe SET 
                                title=:title,
                                description=:description,
                                updatedBy=:updatedBy,
                                updatedAt=:updatedAt
                            WHERE id=:id"
                    , array(
                ':title' => $this->title,
                ':description' => $this->description,
                ':updatedBy' => $this->updatedBy->getId(),
                ':updatedAt' => $this->updatedAt,
                ':id' => $this->id));
        }

        // -----------------------

        CrDatabase::query("DELETE FROM ingredient WHERE recipeId=:recipeId", array(':recipeId' => $this->id));

        foreach ($this->ingredients as /* @var $ingredient CrIngredient */ $ingredient) {
            $ingredient->setRecipeId($this->id);
            $ingredient->saveToDatabase();
        }

        // -----------------------

        CrDatabase::query("DELETE FROM tag WHERE recipeId=:recipeId", array(':recipeId' => $this->id));

        foreach ($this->tags as /* @var $tag CrTag */ $tag) {
            $tag->setRecipeId($this->id);
            $tag->saveToDatabase();
        }
    }

    public static function getObjectFromDatabaseResult($row, $light = false) {
        if (array_key_exists('id', $row)) {

            $recipe = new CrRecipe();
            $recipe->id = $row['id'];
            $recipe->title = htmlentities($row['title']);
            $recipe->description = htmlentities($row['description']);
            $recipe->createdAt = $row['createdAt'];
            $recipe->updatedAt = $row['updatedAt'];
            $recipe->deletedAt = $row['deletedAt'];

            if (!$light) {
                $recipe->createdBy = CrUser::loadFromDatabaseById($row['createdBy']);
                $recipe->updatedBy = CrUser::loadFromDatabaseById($row['updatedBy']);
                $recipe->deletedBy = CrUser::loadFromDatabaseById($row['deletedBy']);

                $recipe->ingredients = array();
                $ingredients = CrIngredient::loadFromDatabaseByRecipeId($recipe->id);
                if ($ingredients) {
                    foreach ($ingredients as $ingredient) {
                        array_push($recipe->ingredients, $ingredient);
                    }
                }

                $recipe->tags = array();
                $tags = CrTag::loadFromDatabaseByRecipeId($recipe->id);
                if ($tags) {
                    foreach ($tags as $tag) {
                        array_push($recipe->tags, $tag);
                    }
                }
            }

            return $recipe;
        } else {
            return false;
        }
    }

    public static function getObjectsFromDatabaseResult($rows, $light = false) {
        $recipes = array();

        foreach ($rows as $row) {
            array_push($recipes, CrRecipe::getObjectFromDatabaseResult($row, $light));
        }

        return $recipes;
    }

    public static function loadFromDatabase($id, $light = false) {

        $rows = CrDatabase::queryFetch(
                        "SELECT * FROM recipe WHERE id=:id"
                        , array(
                    ':id' => $id)
        );

        if (count($rows) === 1) {
            return CrRecipe::getObjectFromDatabaseResult($rows[0], $light);
        } else {
            return false;
        }
    }

    public static function createDatabaseTable() {
        CrDatabase::query("CREATE TABLE IF NOT EXISTS recipe (
                                id           INT NOT NULL AUTO_INCREMENT,
                                title        VARCHAR(128) NOT NULL,
                                description  TEXT NOT NULL,
                                createdAt    DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                createdBy    INT NOT NULL,
                                updatedAt    DATETIME DEFAULT NULL,
                                updatedBy    INT DEFAULT NULL,
                                deletedAt    DATETIME DEFAULT NULL,
                                deletedBy    INT DEFAULT NULL,
                                FOREIGN KEY (createdBy) REFERENCES user(id),
                                FOREIGN KEY (updatedBy) REFERENCES user(id),
                                FOREIGN KEY (deletedBy) REFERENCES user(id),
                                UNIQUE (id),
                                FULLTEXT (title, description),
                                PRIMARY KEY (id)
                            )  CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    }

}
