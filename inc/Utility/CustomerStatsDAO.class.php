<?php


class CustomerStatsDAO   {


    private static $db; 

    static function init()  {
        //Initialize the PDO Agent for our DAO class
        try {
            self::$db = new PDOAgent("CustomerStats");
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    //List customers
    static function listStats() : array {

        $sqlQuery = "SELECT customerId, COUNT(DISTINCT orderId) AS numOrders, SUM(total) AS totalValue FROM orders o GROUP BY customerId;";

        //Query!
        self::$db->query($sqlQuery);

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

}