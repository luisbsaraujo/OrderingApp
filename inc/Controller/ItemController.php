<?php

/*
    This controller will keep the actions: delete, edit, form, insert, list and update for Items
*/

//List items
function listItems(){
    //Create array of items
    $items = ItemDAO::listItems();

    //Create new instance or Customer class
    $customer = new Customer();

    //Add data
    if (isset($_POST["cstId"])){
        $customer = CustomerDAO::getCustomerById($_POST["cstId"]);
    } else {
        $customer = CustomerDAO::getCustomerById($_GET["cstId"]);
    }

    //Show form item List
    Page::showFormItemList($items, $customer);
}


//List items by description
function listItemsByDescription(String $itemDesc){
    //Create array of items
    $items = ItemDAO::listItemsByDescription($itemDesc);

    //Create new instance or Customer class
    $customer = new Customer();

    //Add data
    if (isset($_POST["cstId"])){
        $customer = CustomerDAO::getCustomerById((int)$_POST["cstId"]);
    } else {
        $customer = CustomerDAO::getCustomerById((int)$_GET["cstId"]);
    }

    //Show form item List
    Page::showFormItemList($items, $customer);
}

//List items by id
function listItemsById(String $itemId){
    //Create array of items
    $items[] = ItemDAO::getItemById((int)$itemId);

    //Create new instance or Customer class
    $customer = new Customer();

    //Add data
    if (isset($_POST["cstId"])){
        $customer = CustomerDAO::getCustomerById($_POST["cstId"]);
    } else {
        $customer = CustomerDAO::getCustomerById($_GET["cstId"]);
    }

    //Show Item Search form
    Page::itemSearchForm($itemId, $items[0]->getDescription());
    //Show form item List
    Page::showFormItemList($items, $customer);
}

//Call form - Item
function formItem(){
    //Create new instance of Item class
    $item = new Item();

    $cstId = -1;
    if (isset($_POST["cstId"])){
        $cstId = $_POST["cstId"];
    } if (isset($_GET["cstId"])){
        $cstId = $_GET["cstId"];
    }
    
    //Show New item form
    Page::showFormItem($item, $cstId, ACTION_NEW_ITEM);
}

//Insert new item
function insertItem(){
    //Create new instance of item class
    $item = new Item();

    //Add data
    $item->setDescription($_POST["itemDesc"]);
    $item->setPrice($_POST["itemPrice"]);

    //Insert new item
    return ItemDAO::createItem($item);
}

//Edit Item
function editItem(){
    //Create new instance of Item class
    $item = new Item();

    //Add data
    $item = ItemDAO::getItemById($_GET["itemId"]);

    $cstId = -1;
    if (isset($_POST["cstId"])){
        $cstId = $_POST["cstId"];
    } if (isset($_GET["cstId"])){
        $cstId = $_GET["cstId"];
    }
    
    //Show New item form
    Page::showFormItem($item, $cstId, ACTION_EDIT_ITEM);
}

//Update item
function updateItem(){
    //Create new instance or item class
    $item = new Item();

    //Add data
    $item->setDescription($_POST["itemDesc"]);
    $item->setPrice($_POST["itemPrice"]);
    $item->setItemID($_POST["itemId"]);

    //Update item
    return ItemDAO::updateItem($item);
}

//Delete item
function deleteItem(){
    //Delete item
    return ItemDAO::deleteItem($_GET["itemId"]);
}

//New search item feature box
function showFormSearchItem($cstId, String $itemDesc = null){
    Page::itemSearchForm($cstId, $itemDesc);
}

?>