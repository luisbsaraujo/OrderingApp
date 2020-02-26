<?php


class ItemDAO   {

// +-------------+--------------+------+-----+---------+----------------+
// | Field       | Type         | Null | Key | Default | Extra          |
// +-------------+--------------+------+-----+---------+----------------+
// | itemId      | smallint(6)  | NO   | PRI | NULL    | auto_increment |
// | description | varchar(100) | NO   |     | NULL    |                |
// | price       | decimal(8,2) | NO   |     | NULL    |                |
// +-------------+--------------+------+-----+---------+----------------+

    private static $db; 

    static function init()  {
        //Initialize the PDO Agent for our DAO class
        try {
            self::$db = new PDOAgent("Item");
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    //List items
    static function listItems() : array {

        $sqlQuery = "SELECT * FROM item ORDER BY description;";

        //Query!
        self::$db->query($sqlQuery);

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

    //List items by description
    static function listItemsByDescription(String $itemDesc) : array {

        $sqlQuery = "SELECT * FROM item WHERE description LIKE :description ORDER BY description;";

        //Query!
        self::$db->query($sqlQuery);

        //Bind!
        self::$db->bind(':description', '%'.$itemDesc.'%');
        
        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

    //Get item by itemId
    static function getItemById(int $vItemId) : Item {

        $sqlQuery = "SELECT * FROM item WHERE itemId=:itemId;";

        //Query!
        self::$db->query($sqlQuery);

        self::$db->bind(':itemId', $vItemId);

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->singleResult();
    }

    //Create item
    static function createItem(Item $newItem)    {

        $sqlInsert = "INSERT INTO item (description, price)
                        VALUES(:description, :price);";

        //Query!
        self::$db->query($sqlInsert);

        //Bind!
        self::$db->bind(':description', $newItem->getDescription());
        self::$db->bind(':price', $newItem->getPrice());


        //Execute
        return self::$db->execute();
    }

    static function updateItem(Item $vItem)    {

        $sqlUpdate = "UPDATE item 
                         SET description=:description, price=:price
                       WHERE itemId=:itemId;";

        //Query!
        self::$db->query($sqlUpdate);

        //Bind!
        self::$db->bind(':description', $vItem->getDescription());
        self::$db->bind(':price', $vItem->getPrice());
        self::$db->bind(':itemId', $vItem->getItemID());

        //Execute
        return self::$db->execute();
    }

    static function deleteItem(int $vItemId)    {

        $sqlDelete = "DELETE FROM item 
                       WHERE itemId=:itemId;";

        //Query!
        self::$db->query($sqlDelete);

        //Bind!
        self::$db->bind(':itemId', $vItemId);

        //Execute
        return self::$db->execute();
    }

    //List items by customer orders
    static function listItemsByCustomerOrders(int $vCstId) : array {

        $sqlQuery = "SELECT * FROM item i WHERE EXISTS (SELECT 1 FROM orders o WHERE i.itemId = o.itemId and o.customerId = :customerId);";

        //Query!
        self::$db->query($sqlQuery);

        //Bind!
        self::$db->bind(':customerId', $vCstId);

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

    //List items by customer orders and description
    static function listItemsByCustomerOrdersAndDesc(int $vCstId, $vItemDesc) : array {

        $sqlQuery = "SELECT * FROM item i WHERE EXISTS (SELECT 1 FROM orders o 
           WHERE i.itemId = o.itemId and o.customerId = :customerId)
             AND i.description LIKE :itemDesc;";

        //Query!
        self::$db->query($sqlQuery);

        //Bind!
        self::$db->bind(':customerId', $vCstId);
        self::$db->bind(':itemDesc', '%'.$vItemDesc.'%');

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }
}