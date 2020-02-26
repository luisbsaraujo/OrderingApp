<?php

/*
    This controller will keep the actions: delete, insert and edit for Orders
*/

//Insert new order
function insertOrder(){
    
    //declaring default values
    $itemId = 0;
    $qtty = 0;
    $price = 0;
    $newItem = false;
    $actionOK = true;

    //looping through $_POST associative array and changing values
    foreach ($_POST as $key => $value) {
        if (substr($key,0,6) === 'itemId') {
            $itemId = $value;
            $newItem = false;
        } else if(substr($key,0,8) == 'itemQtty') {
            $qtty = $value;
        } else if(substr($key,0,9) == 'itemPrice') {
            $price = $value;
            $newItem = true;
        }

        //assemble new order
        if ($newItem == true && $qtty > 0) {
            $orders = new Orders();
            $orders->setCustomerID($_POST["cstId"]);
            $orders->setItemID($itemId);
            $orders->setQtty($qtty);
            $orders->setTotal($qtty * $price);
            $orders->setOrderID(-1);

            $actionOK = OrderSDAO::createOrder($orders);

            $newItem = false;
        }

        if (!$actionOK) {
            break;
        }
    }

    $actionOK = OrdersDAO::updateLastInsertedOrderId();

    return $actionOK;
}

//List orders
function listOrders(){

    // if got ID from hidden form field or by a GET method copy customer ID to local variable
    if (isset($_POST["cstId"])){
        $cstId = $_POST["cstId"];
    } else if (isset($_GET["cstId"])) {
        $cstId = $_GET["cstId"];
    }

    //Create an array of orders for a given customer ID
    $orders = OrderSDAO::getOrdersByCstId($cstId);

    //Create new instance or Customer class
    $customer = new Customer();

    //Add data
    $customer = CustomerDAO::getCustomerById($cstId);

    //List items by customer orders
    $items = ItemDAO::listItemsByCustomerOrders($cstId);

    //Show table list of customers
    Page::listOrders($orders, $items, $customer);
}

//List orders
function listOrdersBySearchCriteria($cstId){

    if(!empty(trim($_POST["cstOrder"]))){
        $cstOrder = (int)trim($_POST["cstOrder"]);
    } else {
        $cstOrder = -1;
    }
    
    if(!empty(trim($_POST["itemDesc"]))){
        $itemDesc = trim($_POST["itemDesc"]);
    } else {
        $itemDesc = '';
    }

    //Create array of orders
    $orders = OrderSDAO::getOrdersBySearchCrietria($cstId, $cstOrder, $itemDesc);

    //Create new instance or Customer class
    $customer = new Customer();

    //Add data
    $customer = CustomerDAO::getCustomerById($cstId);

    if (!empty(trim($_POST["itemDesc"]))){
        $items = ItemDAO::listItemsByCustomerOrdersAndDesc($cstId, $_POST["itemDesc"]);
    } else {
        $items = ItemDAO::listItemsByCustomerOrders($cstId);
    }
    
    //Show table list of customers
    Page::listOrders($orders, $items, $customer);
}

//Delete Order
function deleteOrder(){
    //Delete item
    return OrdersDAO::deleteOrder($_GET["orderId"], $_GET["itemId"]);
}

//New search order feature box
function showFormSearchOrder($cstId, $itemDesc = "", $cstOrder = ""){
    Page::orderSearchForm($cstId, $itemDesc, $cstOrder);
}

?>