<?php


class CustomerDAO   {

// +------------+--------------+------+-----+---------+----------------+
// | Field      | Type         | Null | Key | Default | Extra          |
// +------------+--------------+------+-----+---------+----------------+
// | customerId | smallint(6)  | NO   | PRI | NULL    | auto_increment |
// | first_name | varchar(100) | NO   |     | NULL    |                |
// | last_name  | varchar(100) | NO   |     | NULL    |                |
// | email      | varchar(50)  | NO   |     | NULL    |                |
// | phone      | varchar(12)  | NO   |     | NULL    |                |
// +------------+--------------+------+-----+---------+----------------+

    private static $db; 

    static function init()  {
        //Initialize the PDO Agent for our DAO class
        try {
            self::$db = new PDOAgent("Customer");
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    //List customers
    static function listCustomers() : array {

        $sqlQuery = "SELECT * FROM customer order by first_name, last_name;";

        //Query!
        self::$db->query($sqlQuery);

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

    //List customers
    static function listCustomersByEmail(String $email) : array {

        $sqlQuery = "SELECT * FROM customer WHERE email LIKE :email ORDER BY first_name, last_name;";

        //Query!
        self::$db->query($sqlQuery);

        //Bind!
        self::$db->bind(':email', '%'.$email.'%');

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->getResultSet();
    }

    //Get customer by customerId
    static function getCustomerById(int $vCustomerId) : Customer {

        $sqlQuery = "SELECT * FROM customer WHERE customerId=:customerId;";

        //Query!
        self::$db->query($sqlQuery);

        //Bind!
        self::$db->bind(':customerId', $vCustomerId);

        //Execute
        self::$db->execute();

        //Get results
        return self::$db->singleResult();
    }

    //Create customer
    static function createCustomer(Customer $newCst)    {

        $sqlInsert = "INSERT INTO customer (first_name, last_name, email, phone)
                        VALUES(:first_name, :last_name, :email, :phone);";

        //Query!
        self::$db->query($sqlInsert);

        //Bind!
        self::$db->bind(':first_name', $newCst->getFirstName());
        self::$db->bind(':last_name', $newCst->getLastName());
        self::$db->bind(':email', $newCst->getEmail());
        self::$db->bind(':phone', $newCst->getPhone());

        //Execute
        return self::$db->execute();
    }

    static function updateCustomer(Customer $vCst)    {

        $sqlUpdate = "UPDATE customer
                         SET first_name=:first_name, last_name=:last_name, email=:email, phone=:phone
                       WHERE customerId=:customerId;";

        //Query!
        self::$db->query($sqlUpdate);

        //Bind!
        self::$db->bind(':first_name', $vCst->getFirstName());
        self::$db->bind(':last_name', $vCst->getLastName());
        self::$db->bind(':email', $vCst->getEmail());
        self::$db->bind(':phone', $vCst->getPhone());
        self::$db->bind(':customerId', $vCst->getCustomerID());

        //Execute
        return self::$db->execute();
    }

    static function deleteCustomer(int $vCustomerId) {

        $sqlDelete = "DELETE FROM customer
                       WHERE customerId=:customerId;";
        //Query!
        self::$db->query($sqlDelete);

        //Bind!
        self::$db->bind(':customerId', $vCustomerId);

        //Execute
        return self::$db->execute();
    }
}