<?php

class CrDatabase {

    public static function handle_sql_errors($query, $params, $error_message) {
        echo '<pre>';
        echo $query;
        echo "\n";
        print_r($params);
        echo '</pre>';
        echo $error_message;
        die;
    }

    public static function query($query, $params = array()) {
        return CrDatabase::pdoQuery($query, $params, false);
    }

    public static function queryFetch($query, $params = array()) {
        return CrDatabase::pdoQuery($query, $params, true);
    }

    private static function pdoQuery($query, $params = array(), $doFetch) {
        $db = new PDO('mysql:dbname=' . CrConfig::databaseName . ';host='.CrConfig::databaseHost.';charset=utf8', CrConfig::databaseUser, CrConfig::databasePassword);


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            // 'INSERT INTO people(name, city) VALUES(:name, :city)'
            $statement = $db->prepare($query);

            // array(':name' => 'Bob', ':city' => 'Montreal')
            $statement->execute($params);

            if ($doFetch) {

                $rows = array();
                while ($row = $statement->fetch()) {
                    array_push($rows, $row);
                }

                return $rows;
            } else {
                return $db->lastInsertId();
            }
        } catch (PDOException $e) {
            CrDatabase::handle_sql_errors($query, $params, $e->getMessage());
        }
    }

}
