<?php

/*
    This controller will keep the actions: delete, edit, form, insert, list and update for Customer
*/

//Call form - Customer
function formCustomer(){
    //Create new instance of Customer class
    $customer = new Customer();
    
    //Show New Customer form
    Page::showFormCustomer($customer, ACTION_NEW_CUSTOMER);
}


//Insert new customer
function insertCustomer(){
    //Create new instance of Customer class
    $customer = new Customer();

    //Add data
    $customer->setFirstName($_POST["cstFName"]);
    $customer->setLastName($_POST["cstLName"]);
    $customer->setEmail($_POST["cstEmail"]);
    $customer->setPhone($_POST["cstPhone"]);

    //Insert new customer
    return CustomerDAO::createCustomer($customer);
}

//List customers
function listCustomers(){
    //Create array of customers
    $customers = CustomerDAO::listCustomers();

    //Create array of customerStats
    $customersStats = CustomerStatsDAO::listStats();

    //Show table list of customers
    Page::listCustomers($customers, $customersStats);
}

//List customers by email
function listCustomersByEmail(){

    if(isset($_GET["cstEmail"])){
        $email = $_GET["cstEmail"];
    } else {
        $email = $_POST["cstEmail"];
    }

    //Create array of customers
    $customers = CustomerDAO::listCustomersByEmail($email);

    //Create array of customerStats
    $customersStats = CustomerStatsDAO::listStats();

    //Show form seach customer
    Page::emailSearchForm($email);
    
    //Show table list of customers
    Page::listCustomers($customers, $customersStats);
}

//Delete customer
function deleteCustomer(){
    //Delete customer
    return CustomerDAO::deleteCustomer($_GET["cstId"]);
}

//Edit customer
function editCustomer(){
    //Create new instance or Customer class
    $customer = new Customer();

    //Add data
    if(isset($_GET["cstId"])){
        $customer->setFirstName($_GET["cstFName"]);
        $customer->setLastName($_GET["cstLName"]);
        $customer->setEmail($_GET["cstEmail"]);
        $customer->setPhone($_GET["cstPhone"]);
        $customer->setCustomerID($_GET["cstId"]);
    } else {
        $customer->setFirstName($_POST["cstFName"]);
        $customer->setLastName($_POST["cstLName"]);
        $customer->setEmail($_POST["cstEmail"]);
        $customer->setPhone($_POST["cstPhone"]);
        $customer->setCustomerID($_POST["cstId"]);
    }

    //Show form - edit customer
    Page::showFormCustomer($customer, ACTION_EDIT_CUSTOMER);
}

//Update customer
function updateCustomer(){
    //Create new instance or Customer class
    $customer = new Customer();

    //Add data
    $customer->setFirstName($_POST["cstFName"]);
    $customer->setLastName($_POST["cstLName"]);
    $customer->setEmail($_POST["cstEmail"]);
    $customer->setPhone($_POST["cstPhone"]);
    $customer->setCustomerID($_POST["cstId"]);

    //Update customer
    return CustomerDAO::updateCustomer($customer);
}

//Show form Search by email
function showFormSearchEmail(String $email = null){
    Page::emailSearchForm($email);
}

?>