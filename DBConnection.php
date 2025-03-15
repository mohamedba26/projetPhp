<?php
    class DBConnection {
        private static $pdo;

        public static function getConnection() {
            if (self::$pdo === null) {
                try {
                    self::$pdo = new PDO("mysql:host=localhost;dbname=projet_web;", "root", "");
                } catch (PDOException $e) {
                    self::$pdo = null;
                }
            }
            return self::$pdo;
        }
    }
?>