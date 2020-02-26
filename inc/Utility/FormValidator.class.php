<?php

class FormValidator {

  static function validateFormCustomer() {
    
    //this function validate customer form for each given field

    $err = [];

    //first name validation
    if(empty(trim($_POST["cstFName"]))) {
      $err[] = "First name is required.";
    } else if (strlen(trim($_POST["cstFName"])) > 100) {
      $err[] = "First name should be less than 100 chars.";
    }

    //last name validation
    if(empty(trim($_POST["cstLName"]))) {
      $err[] = "Last name is required!";
    } else if (strlen(trim($_POST["cstLName"])) > 100) {
      $err[] = "Last name should be less than 100 chars.";
    }

    //e-mail validation
    if(empty(trim($_POST["cstEmail"]))) {
      $err[] = "Email is required.";
    } else if (strlen(trim($_POST["cstEmail"])) > 50) {
      $err[] = "Email should be less than 50 chars.";
    } else {
      $result = filter_input(INPUT_POST, 'cstEmail', FILTER_VALIDATE_EMAIL);
      if (is_null($result) || ($result === false)) {
        $err[] = 'Email not valid.';
      }
    }

    //phone validation
    if(empty(trim($_POST["cstPhone"]))) {
      $err[] = "Phone is required.";
    } else if (strlen(trim($_POST["cstPhone"])) > 12) {
      $err[] = "Phone should be less than 12 chars.";
    } else {
      $inputVar = str_replace("-", "", trim($_POST["cstPhone"]));
      if (!preg_match('/^([0-9]+)$/', $inputVar)) {
        $err[] = 'Phone not valid.';
      }
    }

    return $err;
  }

  static function validateFormItem() {
    
    //this function validate item form for each given field

    // initialize error array
    $err = [];

    //description validation
    if(empty(trim($_POST["itemDesc"]))) {
      $err[] = "Description is required.";
    } else if (strlen(trim($_POST["itemDesc"])) > 100) {
      $err[] = "Description should be less than 100 chars.";
    }

    //price validation
    if(empty(trim($_POST["itemPrice"]))) {
      $err[] = "Price is required.";
    } else {
      $result = filter_input(INPUT_POST, 'itemPrice', FILTER_VALIDATE_FLOAT);
      if (is_null($result) || ($result === false)) {
        $err[] = 'Price not valid.';
      } else {
        $valuePrice = $_POST["itemPrice"];
        if  ($valuePrice <= 0.0 || $valuePrice > 999999.99){
          $err[] = 'Price must be a positive number less than 999,999.99';
        }
      }
    }

    return $err;
  }

  static function validateFormOrders() {

    //this function validate orders

    $err = [];
    
    $qtty = 0;
    $price = 0;
    $newItem = false;
    $hasItems = false;
     

    foreach ($_POST as $key => $value) {
        if (substr($key,0,6) === 'itemId') {
            $newItem = false;
        } else if(substr($key,0,8) == 'itemQtty') {
            $qtty = $value;
            $result = filter_input(INPUT_POST, $key, FILTER_VALIDATE_INT);
            if (is_null($result) || ($result === false)) {
              $err[] = "Quantity must be an integer value.";
              return $err;
            } else if ( $qtty < 0){
              $err[] = "Quantity must be a positive integer value.";
              return $err;
            }
        } else if(substr($key,0,9) == 'itemPrice') {
            $price = $value;
            $newItem = true;
        }

        //quantity and price validation
        if ($newItem == true && $qtty > 0) {
          if (($price * $qtty) > 999999.99 || ($price * $qtty) <= 0.0) {
            $err[] = "Price times Quantity must be a positive number less than 999,999.99";
            return $err;
          }
          $hasItems = true;
        }

    }

    if (!$hasItems){
      $err[] = "One order must have at least one item.";
    }

    return $err;
  }

  static function validateFormSearchCustomer() {

    //this function validate customer search

    $err = [];

    //validate e-mail lenght
    if(empty(trim($_POST["cstEmail"]))) {
      return $err;
    } else if (strlen(trim($_POST["cstEmail"])) > 50) {
      $err[] = "Email should be less than 50 chars.";
    }

    return $err;
  }

  static function validateFormSearchItem() {

    //this function validate item search box field

    $err = [];

    //validate maximum lenght for item description
    if(empty(trim($_POST["itemDesc"]))) {
      return $err;
    } else if (strlen(trim($_POST["itemDesc"])) > 100) {
      $err[] = "Description should be less than 100 chars.";
    }

    return $err;
  }

  static function validateFormSearchOrders() {
    
    //this function validate order search

    $err = [];

    if(empty(trim($_POST["cstOrder"])) && empty(trim($_POST["itemDesc"]))) {
      //$err[] = "N# Order or Description must be entered.";
      return $err;
    } 

    $result = filter_input(INPUT_POST, 'cstOrder', FILTER_VALIDATE_INT);
    $orderNotValid = (is_null($result) || ($result === false));
    
    $itemDescNotValid = (empty(trim($_POST["itemDesc"])) || strlen(trim($_POST["itemDesc"])) > 100);

    //validate order number and description
    if (($orderNotValid && $itemDescNotValid)){
      if ($orderNotValid)
        $err[] = "Description must not be empty and must be less than 100 chars.";
      if ($itemDescNotValid)        
        $err[] = "Order N# must be an integer value.";
    }

    return $err;
  }

}

?>