<?php

// +------------+--------------+------+-----+---------+----------------+
// | Field      | Type         | Null | Key | Default | Extra          |
// +------------+--------------+------+-----+---------+----------------+
// | customerId | smallint(6)  | NO   | PRI | NULL    | auto_increment |
// | first_name | varchar(100) | NO   |     | NULL    |                |
// | last_name  | varchar(100) | NO   |     | NULL    |                |
// | email      | varchar(50)  | NO   |     | NULL    |                |
// | phone      | varchar(12)  | NO   |     | NULL    |                |
// +------------+--------------+------+-----+---------+----------------+

class Customer {

    //Attributes
    private $customerId;
    private $first_name;
    private $last_name;
    private $email;
    private $phone;
    
    //Setters
    function setCustomerID(int $newCustomerID)  {
        $this->customerId = $newCustomerID;
    }

    function setFirstName(string $newFirstName)   {
        $this->first_name = $newFirstName;
    }

    function setLastName(string $newLastName)   {
        $this->last_name = $newLastName;
    }
    
    function setEmail(string $newEmail) {
        $this->email = $newEmail;
    }

    function setPhone(string $newPhone) {
        $this->phone = $newPhone;
    }
    
    //Getters
    function getCustomerID() : int   {
        return $this->customerId;
    }

    function getFirstName() : string {
        return $this->first_name;
    }

    function getLastName() : string {
        return $this->last_name;
    }

    function getEmail() : string {
        return $this->email;
    }

    function getPhone() : string {
        return $this->phone;
    }

}

?>