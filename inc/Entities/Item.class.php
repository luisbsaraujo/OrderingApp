<?php

// +-------------+--------------+------+-----+---------+----------------+
// | Field       | Type         | Null | Key | Default | Extra          |
// +-------------+--------------+------+-----+---------+----------------+
// | itemId      | smallint(6)  | NO   | PRI | NULL    | auto_increment |
// | description | varchar(100) | NO   |     | NULL    |                |
// | price       | decimal(8,2) | NO   |     | NULL    |                |
// +-------------+--------------+------+-----+---------+----------------+

class Item {

    //Attributes
    private $itemId;
    private $description;
    private $price;
    
    //Setters
    function setItemID(int $newItemId)  {
        $this->itemId = $newItemId;
    }

    function setDescription(string $newDescription)   {
        $this->description = $newDescription;
    }

    function setPrice(float $newPrice)   {
        $this->price = $newPrice;
    }
    
    
    //Getters
    function getItemID() : int   {
        return $this->itemId;
    }

    function getDescription() : string {
        return $this->description;
    }

    function getPrice() : float {
        return $this->price;
    }

}

?>