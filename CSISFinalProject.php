<?php

//include files
require_once("inc/config.inc.php");
require_once("inc/Utility/PDOAgent.class.php");
require_once("inc/Utility/Page.class.php");

require_once("inc/Entities/Customer.class.php");
require_once("inc/Entities/CustomerStats.class.php");
require_once("inc/Entities/Item.class.php");
require_once("inc/Entities/Orders.class.php");

require_once("inc/Utility/CustomerDAO.class.php");
require_once("inc/Utility/CustomerStatsDAO.class.php");
require_once("inc/Utility/ItemDAO.class.php");
require_once("inc/Utility/OrdersDAO.class.php");

require_once("inc/Utility/WebServiceExchangeRates.class.php");

require_once("inc/Utility/FormValidator.class.php");

//controller for each entity
require_once("inc/Controller/CustomerController.php");
require_once("inc/Controller/ItemController.php");
require_once("inc/Controller/OrdersController.php");

date_default_timezone_set(TIME_ZONE);

//Initialize the DAOs, which controls CRUD operations in Database
CustomerDAO::init();
CustomerStatsDAO::init(); //list a summary of orders for each customer
ItemDAO::init();
OrdersDAO::init();

//Get data from webService
Page::$currencyRates = array();
foreach(CURRENCIES as $curr){
    WebServiceExchangeRates::$currency = $curr;
    Page::$currencyRates[$curr] = WebServiceExchangeRates::getExchangeRate();
}


//If there was an action, write it to $action
//the default action is ACTION_NEW
if (isset($_POST["action"])){
    $action = $_POST["action"];
} else if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = ACTION_LIST_CUSTOMER;
}

//If there was an client Id, write it to $cstId
if (isset($_POST["cstId"])){
    $cstId = $_POST["cstId"];
} else if (isset($_GET["cstId"])) {
    $cstId = $_GET["cstId"];
} else {
    $cstId = -1;
}

$lastActionStatus = NO_LAST_ACTION;
Page::$errors = []; // array to track the errors

//setup title & exchange rates
Page::$title = "PHP Final Project";

//Page header
Page::header();


switch ($action){
    //do the appropriate function for the respective action
        
    case ACTION_DELETE_CUSTOMER;
        //Delete the customer
        if (deleteCustomer()){
            $lastActionStatus = LAST_ACTION_OK;
        } else {
            $lastActionStatus = LAST_ACTION_NOK;
            Page::$errors[] = 'Error deleting customer: '.$cstId;
            Page::$errors[] = 'You can not delete customers with 1 or more orders.';
        }
        //Show last action status
        Page::showLastActionStatus($lastActionStatus);

        $action = ACTION_LIST_CUSTOMER;
        showFormSearchEmail();
        listCustomers();
        formCustomer();
        break;

    case ACTION_EDIT_CUSTOMER;
        //Edit the customer
        listCustomersByEmail();
        editCustomer();
        break;

    case ACTION_INSERT_CUSTOMER;
        //Insert new customer
        Page::$errors = FormValidator::validateFormCustomer();
        if (empty(Page::$errors)){
            if (insertCustomer()){
                $lastActionStatus = LAST_ACTION_OK;
            } else {
                $lastActionStatus = LAST_ACTION_NOK;
                Page::$errors[] = 'Error creating new customer';
            }
            //Show last action status
            Page::showLastActionStatus($lastActionStatus);
        } else {
            Page::showFormErros();
        }
        $action = ACTION_LIST_CUSTOMER;
        showFormSearchEmail();
        listCustomers();
        formCustomer();
        break;

    case ACTION_UPDATE_CUSTOMER;
        //Update customer
        Page::$errors = FormValidator::validateFormCustomer();
        if (empty(Page::$errors)){
            if (updateCustomer()){
                $lastActionStatus = LAST_ACTION_OK;
            } else {
                $lastActionStatus = LAST_ACTION_NOK;
                Page::$errors[] = 'Error updating customer: '.$cstId;
            }
            //Show last action status
            Page::showLastActionStatus($lastActionStatus);
            
            $action = ACTION_LIST_CUSTOMER;
            showFormSearchEmail();
            listCustomers();
            formCustomer();
        } else {
            Page::showFormErros();
            
            $action = ACTION_EDIT_CUSTOMER;
            showFormSearchEmail();
            listCustomers();
            editCustomer();
        }
        break;  

    case ACTION_SEARCH_CUSTOMER;
        //view list of customers
        $action = ACTION_LIST_CUSTOMER;
        Page::$errors = FormValidator::validateFormSearchCustomer();
        if (empty(Page::$errors)){
            if (empty($_POST["cstEmail"])){
                showFormSearchEmail();
                listCustomers();
            } else {
                listCustomersByEmail();
            }
        } else {
            Page::showFormErros();
            showFormSearchEmail($_POST["cstEmail"]);
            listCustomers();
        }
        formCustomer();
        break;
        
    case ACTION_LIST_ITEMS;
        //List Items
        showFormSearchItem($cstId);
        listItems();
        formItem();
        break;

    case ACTION_INSERT_ITEM;
        //Insert new item
        Page::$errors = FormValidator::validateFormItem();
        if (empty(Page::$errors)){
            if (insertItem()){
                $lastActionStatus = LAST_ACTION_OK;
            } else {
                $lastActionStatus = LAST_ACTION_NOK;
                Page::$errors[] = 'Error creating new item.';
            }
            //Show last action status
            Page::showLastActionStatus($lastActionStatus);
        } else {
            Page::showFormErros();
        }
        $action = ACTION_LIST_ITEMS;
        showFormSearchItem($cstId);
        listItems();
        formItem();
        break;    
        
    case ACTION_EDIT_ITEM;
        //Edit the item
        listItemsById($_GET["itemId"]);
        editItem();
        break;
        
    case ACTION_UPDATE_ITEM;
        //Update item
        Page::$errors = FormValidator::validateFormItem();
        if (empty(Page::$errors)){
            if (updateItem()){
                $lastActionStatus = LAST_ACTION_OK;
            } else {
                $lastActionStatus = LAST_ACTION_NOK;
                Page::$errors[] = 'Error updating item: '.$_POST["itemId"];
            }
            //Show last action status
            Page::showLastActionStatus($lastActionStatus);
        } else {
            Page::showFormErros();
        }
        
        $action = ACTION_LIST_ITEMS;
        showFormSearchItem($cstId);
        listItems();
        formItem();
        break;

    case ACTION_DELETE_ITEM;
        //Delete the item
        if (deleteItem()){
            $lastActionStatus = LAST_ACTION_OK;
        } else {
            $lastActionStatus = LAST_ACTION_NOK;
            Page::$errors[] = 'Error deleting item: '.$cstId;
            Page::$errors[] = 'You cannot delete items already associated with orders.';
        }
        //Show last action status
        Page::showLastActionStatus($lastActionStatus);
        
        $action = ACTION_LIST_ITEMS;
        showFormSearchItem($cstId);
        listItems();
        formItem();
        break;

    case ACTION_SEARCH_ITEM;
        //view list of itens
        $action = ACTION_LIST_ITEMS;
        Page::$errors = FormValidator::validateFormSearchItem();
        if (empty(Page::$errors)){
            showFormSearchItem($cstId, $_POST["itemDesc"]);
            listItemsByDescription($_POST["itemDesc"]);
        } else {
            Page::showFormErros();
            showFormSearchItem($cstId, $_POST["itemDesc"]);
            listItems();
        }
        formItem();
        break;

    case ACTION_INSERT_ORDER;
        //Insert new order

        Page::$errors = FormValidator::validateFormOrders();
        if (empty(Page::$errors)){
            if (insertOrder()){
                $lastActionStatus = LAST_ACTION_OK;
            } else {
                $lastActionStatus = LAST_ACTION_NOK;
                Page::$errors[] = 'Error inserting new item';
            }
            //Show last action status
            Page::showLastActionStatus($lastActionStatus);
            $action = ACTION_LIST_ORDERS;
            showFormSearchOrder($cstId);
            listOrders();
        } else {
            Page::showFormErros();
            //List Items
            showFormSearchItem($cstId);
            listItems();
            formItem();
        }

        break;    
        
    case ACTION_LIST_ORDERS;
        //List Orders
        showFormSearchOrder($cstId);
        listOrders();
        break;

    case ACTION_DELETE_ORDER;
        //Delete the order
        if (deleteOrder()){
            $lastActionStatus = LAST_ACTION_OK;
        } else {
            $lastActionStatus = LAST_ACTION_NOK;
            Page::$errors[] = 'Error deleting item: '.$_GET["itemId"].' from order: '.$_GET["orderId"];
        }
        //Show last action status
        Page::showLastActionStatus($lastActionStatus);
        
        $action = ACTION_LIST_ORDERS;
        showFormSearchOrder($cstId);
        listOrders();
        break; 
        
        
    case ACTION_SEARCH_ORDER;
        //view list of itens
        $action = ACTION_LIST_ORDERS;
        Page::$errors = FormValidator::validateFormSearchOrders();
        if (empty(Page::$errors)){
            showFormSearchOrder($cstId, $_POST["itemDesc"], $_POST["cstOrder"]);
            listOrdersBySearchCriteria($cstId);
        } else {
            Page::showFormErros();
            showFormSearchOrder($cstId);
            listOrders();
        }
        break;        
        
    case ACTION_LIST_CUSTOMER;
        default:
            //view list of customers
            showFormSearchEmail();
            listCustomers();
            formCustomer();
            break;        
    }
    
$lastActionStatus = NO_LAST_ACTION;

//Page footer
Page::footer();