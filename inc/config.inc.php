<?php

//Set database parameters    
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "csis3280bcc");

//Set actions
define("ACTION_LIST_CUSTOMER", "ListCustomer");
define("ACTION_NEW_CUSTOMER", "NewCustomer");
define("ACTION_EDIT_CUSTOMER", "EditCustomer");
define("ACTION_DELETE_CUSTOMER", "DeleteCustomer");
define("ACTION_INSERT_CUSTOMER", "InsertCustomer");
define("ACTION_UPDATE_CUSTOMER", "UpdateCustomer");
define("ACTION_SEARCH_CUSTOMER", "SearchCustomer");

define("ACTION_LIST_ITEMS", "ListItems");
define("ACTION_DELETE_ITEM", "DeleteItem");
define("ACTION_INSERT_ITEM", "InsertItem");
define("ACTION_EDIT_ITEM", "EditItem");
define("ACTION_UPDATE_ITEM", "UpdateItem");
define("ACTION_NEW_ITEM", "NewItem");
define("ACTION_SEARCH_ITEM", "SearchItem");

define("ACTION_LIST_ORDERS", "ListOrders");
define("ACTION_INSERT_ORDER", "InsertOrder");
define("ACTION_DELETE_ORDER", "DeleteOrder");
define("ACTION_SEARCH_ORDER", "SearchOrder");

define("NO_LAST_ACTION", 0);
define("LAST_ACTION_OK", 1);
define("LAST_ACTION_NOK", -1);

define("WEB_SERVICE_URL","https://api.exchangeratesapi.io/latest?base=CAD&symbols=");
define("CURRENCIES", array('USD','EUR'));  // User can add as many currencys as he wish in the array

define("LOG_FILE", "log/error.log");

define("DELETE_ICON", "inc/img/icons8-delete-bin-24.png");
define("EDIT_ICON", "inc/img/icons8-edit-24.png");
define("NEW_ICON", "inc/img/icons8-new-24.png");

define("TIME_ZONE", "America/Vancouver");

?>
