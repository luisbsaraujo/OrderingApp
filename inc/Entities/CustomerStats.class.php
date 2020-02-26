<?php


class CustomerStats {

    //Attributes
    private $customerId;
    private $numOrders;
    private $totalValue;
    
    //Setters
    function setCustomerID(int $newCustomerID)  {
        $this->customerId = $newCustomerID;
    }

    function setNumOrders(int $newNumOrders)   {
        $this->numOrders = $newNumOrders;
    }

    function setTotalValue(float $newTotalValue)   {
        $this->totalValue = $newTotalValue;
    }
    
    
    //Getters
    function getCustomerID() : int   {
        return $this->customerId;
    }

    function getNumOrders() : int {
        return $this->numOrders;
    }

    function getTotalValue() : float {
        return $this->totalValue;
    }


}

?>