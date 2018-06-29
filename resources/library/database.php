<?php

require_once(realpath(dirname(__FILE__) . "/../config.php"));

class Database {
    private static $dbName = "languagequiz";
    private static $dbHost = "localhost";
    private static $dbUser = "root";
    private static $dbPass = "";
    
    private static $cont = null;
    
    public function __construct() {
        die("Init function is not allowed.");
    }
    
    public static function connect() {
        //one connection for all!!
        if(null == self::$cont) {
            try {
                self::$cont = new PDO(
                    "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName,
                    self::$dbUser. self::$dbPass
                );
            }
            catch(PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function disconnect() {
        self::$cont = null;
    }
    
    public static function select($sql) {
        $pdo = Database::connect();
        $pdo->query("SET NAMES utf8");
        $results = [];
        foreach($pdo->query($sql) as $row) {
            $arr = [];
            foreach($row as $k => $v) {
                if(!is_numeric($k)) {
                    $arr[$k] = $v;
                }
            }
            $results[] = $arr;
        }
        Database::disconnect();
        return $results;
    }

    public static function insert($preparedLine, $data) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->query("SET NAMES utf8");
        $stmt = $pdo->prepare($preparedLine);
        foreach($data as $row) {
            $stmt->execute($row);
        }
        Database::disconnect();
    }
}