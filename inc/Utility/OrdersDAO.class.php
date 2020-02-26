<?php


class OrdersDAO   {

// +------------+--------------+------+-----+---------+----------------+
// | Field      | Type         | Null | Key | Default | Extra          |
// +------------+--------------+------+-----+---------+----------------+
// | orderId    | smallint(6)  | NO   | PRI | NULL    | auto_increment |
// | customerId | smallint(6)  | NO   | MUL | NULL    |                |
// | itemId     | smallint(6)  | NO   | MUL | NULL    |                |
// | qtty       | smallint(6)  | NO   |     | NULL    |                |
// | total      | decimal(8,2) | NO   |     | NULL    |                |
// +------------+--------------+------+-----+---------+----------------+

    private static $db; 

    static function init()  {
        //Initialize the PDO Agent for our DAO class
        try {
            self::$db = new PDOAgent("Orders");
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    //Get orders by customerId
    static function getOrdersByCstId(int $vCustomerId) : array {

        $sqlQuery = "SELECT * FROM orders WHERE customerId=:customerId;";

        //Query!
        self::$db->query($sqlQuery);

        //Bind!
        self::$db->bind(':customerId', $vCustomerId);

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

    //Get orders by customerId and orderIds
    static function getOrdersBySearchCrietria(int $vCustomerId, int $vOrderId, String $itemDesc) : array {

        $sqlQuery = "SELECT * FROM orders o WHERE o.customerId=:customerId ";
        if ($vOrderId > 0) {
            $sqlQuery .= " AND o.orderId=:orderId ";
        }
        if (!empty($itemDesc)) {
            $sqlQuery .= " AND EXISTS (SELECT 1 FROM item i WHERE o.itemId = i.itemId and i.description LIKE :itemDesc) ";
        }

        //Query!
        self::$db->query($sqlQuery);

        //Bind!
        self::$db->bind(':customerId', $vCustomerId);
        if ($vOrderId > 0) {
            self::$db->bind(':orderId', $vOrderId);
        }
        if (!empty($itemDesc)) {
            self::$db->bind(':itemDesc', '%'.$itemDesc.'%');
        }
        

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

    //Create order
    static function createOrder(Orders $newOrder)    {

        $sqlInsert = "INSERT INTO orders (orderId, customerId, itemId, qtty, total)
                        VALUES(:orderId, :customerId, :itemId, :qtty, :total);";

        //Query!
        self::$db->query($sqlInsert);

        //Bind!
        self::$db->bind(':orderId', $newOrder->getOrderID());
        self::$db->bind(':customerId', $newOrder->getCustomerID());
        self::$db->bind(':itemId', $newOrder->getItemID());
        self::$db->bind(':qtty', $newOrder->getQtty());
        self::$db->bind(':total', $newOrder->getTotal());

        //Execute
        return self::$db->execute();
    }

    //Update Order
    static function updateOrder(Orders $vOrder)    {

        $sqlUpdate = "UPDATE orders
                         SET qtty=:qtty, total=:total
                       WHERE orderId=:orderId AND itemId=:itemId;";

        //Query!
        self::$db->query($sqlUpdate);

        //Bind!
        self::$db->bind(':qtty', $vOrder->getQtty());
        self::$db->bind(':total', $vOrder->getTotal());
        self::$db->bind(':itemId', $vOrder->getItemID());
        self::$db->bind(':orderId', $vOrder->getOrderID());

        //Execute
        self::$db->execute();
    }

    static function deleteOrder(int $vOrderId, int $vItemId)    {

        $sqlDelete = "DELETE FROM orders
                       WHERE orderId=:orderId AND itemId=:itemId;";

        //Query!
        self::$db->query($sqlDelete);

        //Bind!
        self::$db->bind(':orderId', $vOrderId);
        self::$db->bind(':itemId', $vItemId);

        //Execute
        return self::$db->execute();
    }

    //Update Order
    static function updateLastInsertedOrderId()    {

        $sqlUpdate = "UPDATE orders
                         SET orderId = (SELECT maxId FROM (SELECT MAX(orderId)+1 AS maxId FROM orders) AS t)
                       WHERE orderId = -1; ";

        //Query!
        self::$db->query($sqlUpdate);

        //Execute
        return self::$db->execute();
    }
}