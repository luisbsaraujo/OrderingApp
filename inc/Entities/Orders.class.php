<?php

// +------------+--------------+------+-----+---------+----------------+
// | Field      | Type         | Null | Key | Default | Extra          |
// +------------+--------------+------+-----+---------+----------------+
// | orderId    | smallint(6)  | NO   | PRI | NULL    | auto_increment |
// | customerId | smallint(6)  | NO   | MUL | NULL    |                |
// | itemId     | smallint(6)  | NO   | MUL | NULL    |                |
// | qtty       | smallint(6)  | NO   |     | NULL    |                |
// | total      | decimal(8,2) | NO   |     | NULL    |                |
// +------------+--------------+------+-----+---------+----------------+

class Orders {

    //Attributes
    private $orderId;
    private $customerId;
    private $itemId;
    private $qtty;
    private $total;
    
    //Setters
    function setOrderID(int $newOrderID)  {
        $this->orderId = $newOrderID;
    }

    function setCustomerID(int $newCustomerID)   {
        $this->customerId = $newCustomerID;
    }

    function setItemID(int $newItemID)   {
        $this->itemId = $newItemID;
    }
    
    function setQtty(int $newQtty) {
        $this->qtty = $newQtty;
    }

    function setTotal(float $newTotal) {
        $this->total = $newTotal;
    }
    
    //Getters
    function getOrderID() : int {
        return $this->orderId;
    }

    function getCustomerID() : int   {
        return $this->customerId;
    }

    function getItemID() : int {
        return $this->itemId;
    }

    function getQtty() : int {
        return $this->qtty;
    }

    function getTotal() : float {
        return $this->total;
    }

}

?>