<?php
class DB
{
    private static $con;

    public static function getCon()
    {
        if (!isset(self::$con)) {
            self::$con = mysqli_connect("localhost", "mglsi_user", "passer", "mglsi_news");

            if (mysqli_connect_errno()) {
                echo "Erreur de connexion à la base de données : " . mysqli_connect_error();
                exit();
            }
        }
        return self::$con;
    }
}
