<?php

class Page  {

  public static $title = "Please set the Title";
  public static $currencyRates = array();
  public static $errors = [];
 
  //header function
  static function header()    { ?>
  
    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
        body{
          background-image: url('inc/img/banner-bg.jpg')
          /*  taken from: https://colorlib.com/wp/template/foodfun/ */
        }
        div.container{
          opacity: 0.9
        }

        .msgOk{
          font-weight:bold;
          color:green;
        }

        .msgError{
          font-weight:bold;
          color:red;
        }

        .centerTxt {
          text-align:center;
        }
        </style>
        <title><?php echo self::$title; ?></title>
    </head>
    <body>
    
      <div class="container"> 
          <h1 style="color:white; background-color:teal"><?php echo self::$title; ?></h1>
      </div>

  <?php }

  // footer function
  static function footer()    { ?>
     
    </body>
    <footer>
    <div class="container">
      <p style="color:white" ><strong>Students:</strong></p>
      <p style="color:white" ><strong>Jose Luiz Gomes, Luis Araujo, Pedro Rendon.</strong></p>
    </div>

      <div class="container"> 
        <p style="color:white" >
          <i>Background image taken from: 
            <a href="https://colorlib.com/wp/template/foodfun/"> 
              https://colorlib.com/wp/template/foodfun/ 
            </a>
          </i>
        </p>
      </div>

     
    </footer>
    </html>

  <?php }

  //Display list of Customers
  static function listCustomers($customers, $customersStats)   { ?>
    <div class="container"> 
    <div class="jumbotron">
        <P></P>
        <!-- define table style -->
        <style> 
            table { width: 100%; margin: auto; } 
        </style> 
        <TABLE class="table-striped">
            <TR>
                <TH>First Name</TH>
                <TH>Last Name</TH>
                <TH>Email</TH>
                <TH>Phone</TH>
                <TH>N# Orders</TH>
                <TH>Total Value (CAD$)</TH>
                <?php
                foreach(self::$currencyRates as $key=>$value) {
                  echo '<TH>('.$key.')</TH>';
                }
                ?>
                <TH>Delete</TH>
                <TH>Edit</TH>
                <TH>New<br />Order</TH>
            </TR>

            <?php
            
              echo '<p><h3>Customer List</h3></p>';

              foreach ($customers as $cst) {

                $cstInfo = '&cstId='.$cst->getCustomerID().'&cstFName='.$cst->getFirstName().'&cstLName='.$cst->getLastName().'&cstEmail='.$cst->getEmail().'&cstPhone='.$cst->getPhone(); //copy all information of the customer to a local variable
                $cstStatsNOrders = "0";
                $cstStatsTValue = "0";
                foreach($customersStats as $cstSts) {
                  if ($cst->getCustomerID() == $cstSts->getCustomerID()) {
                    $cstStatsNOrders = $cstSts->getNumOrders();
                    $cstStatsTValue = $cstSts->getTotalValue();
                    break;
                  }
                }
              
                //print row for each customer with all the customer information
                echo '<TR>
                  <TD>'.$cst->getFirstName().'</TD>
                  <TD>'.$cst->getLastName().'</TD>
                  <TD>'.$cst->getEmail().'</TD>
                  <TD>'.$cst->getPhone().'</TD>
                  <TD style="text-align:center">
                    <a href="'.$_SERVER['PHP_SELF'].'?action='.ACTION_LIST_ORDERS.'&cstId='.$cst->getCustomerID().'">'.$cstStatsNOrders.'</a>
                  </TD>
                  <TD style="text-align:right">'.number_format($cstStatsTValue, 2, '.', ',').'|</TD>';

                //add colum(ns) for currencies
                foreach(self::$currencyRates as $key=>$value) {
                  echo '<TD class="centerTxt">'.number_format($cstStatsTValue*$value, 2, '.', ',').'|</TD>';
                }

                //show possible operations for each customer (delete, edit) and orders (create new, list)
                echo'<TD class="centerTxt"><a href="'.$_SERVER['PHP_SELF'].'?action='.ACTION_DELETE_CUSTOMER.'&cstId='.$cst->getCustomerID().'">
                         <img src="'.DELETE_ICON.'" alt="Delete"></a></TD>
                  <TD class="centerTxt"><a href="'.$_SERVER['PHP_SELF'].'?action='.ACTION_EDIT_CUSTOMER.$cstInfo.'"><img src="'.EDIT_ICON.'" alt="Edit"></a></TD>
                  <TD class="centerTxt"><a href="'.$_SERVER['PHP_SELF'].'?action='.ACTION_LIST_ITEMS.$cstInfo.'"><img src="'.NEW_ICON.'" alt="New"></a></TD>
                </TR>';
              }
            ?>
        </TABLE>
      </div>
    </div>
  <?php 
  
  }

  //Display form  Customer
  static function showFormCustomer(Customer $customer, $action){ 
    //This form is used for updating an existing customer 
    //  and for creating a new one
      ?>
      <div class="container"> 
      <div class="jumbotron">
      <?php
      
      //setup action title
      if($action == ACTION_EDIT_CUSTOMER) {
        echo '<p><h3>Edit Customer - '.$customer->getCustomerID().'</h3></p>';
      } else {
        echo '<p><h3>Add Customer</h3></p>';
      }
      ?>

      <form name="formCustomer" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" >
        <fieldset>
          <table>
            <colgroup>
              <col class="first" />
              <col class="second" />
            </colgroup>
            <tr>
              <td>First Name</td>
              <td><input type="text" name="cstFName" id="cstFName" size="100" required="required" 
                    value="<?php if($action == ACTION_EDIT_CUSTOMER) { echo $customer->getFirstName(); } ?>"></td>
            </tr>	
            <tr>
              <td>Last Name</td>
              <td><input type="text" name="cstLName" id="cstLName" size="100" required="required" 
                    value="<?php if($action == ACTION_EDIT_CUSTOMER) { echo $customer->getLastName(); } ?>"></td>
            </tr>	
            <tr>
              <td>Email</td>
              <td><input type="text" name="cstEmail" id="cstEmail" size="50" required="required" 
                    value="<?php if($action == ACTION_EDIT_CUSTOMER) { echo $customer->getEmail(); } ?>"></td>
            </tr>	
            <tr>
              <td>Phone</td>
              <td><input type="text" name="cstPhone" id="cstPhone" size="12" required="required" 
                    value="<?php if($action == ACTION_EDIT_CUSTOMER) { echo $customer->getPhone(); } ?>"></td>
            </tr>	
            <tr>
              <td><input type="submit" value="Save"  class="btn btn-primary" ></td>
              <td><input type="button" value="Cancel"  class="btn btn-primary" onclick=document.location="<?php echo $_SERVER["PHP_SELF"]."?action=".ACTION_LIST_CUSTOMER; ?>"></td>
            </tr>
          </table>
          <input type="hidden" id="action" name="action" value="<?php 
                  if($action == ACTION_NEW_CUSTOMER) {
                    echo ACTION_INSERT_CUSTOMER; 
                  } else if ($action == ACTION_EDIT_CUSTOMER){
                    echo ACTION_UPDATE_CUSTOMER;
                  } ?>">      
          <input type="hidden" id="cstId" name="cstId" value="<?php if($action == ACTION_EDIT_CUSTOMER) { echo $customer->getCustomerID(); } ?>">    
        </fieldset>
      </form>
      </div>
    
    </div>
   <?php }

  //Display msg Status
  static function showLastActionStatus($lastActionStatus){ 
    ?>
    <div class="container"> 
    <div class="jumbotron">
    <?php
      if ($lastActionStatus == LAST_ACTION_OK)  {
        echo '<p class="msgOk">Action performed OK!</p>';
      } else if ($lastActionStatus == LAST_ACTION_NOK) {
        echo '<p class="msgError">ERROR performing last action!</p>';
        foreach(self::$errors as $e) {
          echo '<span class="msgError">'.$e.'<br /></span>';
        }
      }
    
    ?>
    </div>
    </div>
   <?php
  }

  //Display msg Status
  static function showFormErros(){ 
    ?>
    <div class="container"> 
    <div class="jumbotron">
    <?php
      foreach(self::$errors as $e) {
        echo '<p class="msgError">'.$e.'</p>';
      }
      self::$errors = [];
    ?>
    </div>
    </div>
   <?php
  }

  //List Items
  static function showFormItemList($items, $cst){ 
    ?>
    <div class="container"> 
    <div class="jumbotron">
    <?php 
    //This form is used for list items and put orders
      //setup action title
      echo '<p><h3>'.$cst->getFirstName().' '.$cst->getLastName().' - Item List</h3></p>';
      ?>
  
      <form name="formItemList" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" >
        <fieldset>
          <table class="table-striped">
            <TR>
              <TH>Description</TH>
              <TH>Price (CAD$)</TH>
              <?php
                foreach(self::$currencyRates as $key=>$value) {
                  echo '<TH>('.$key.')</TH>';
                }
              ?>
              <TH>Quantity</TH>
              <TH>Delete</TH>
              <TH>Edit</TH>
          </TR>
          <?php
          foreach ($items as $item) {
            $itmId = $item->getItemID();?>
            <tr>
              <td><?php echo $item->getDescription()?>
                  <input type="hidden" id="itemId<?php echo $itmId?>" name="itemId<?php echo $itmId?>" value="<?php echo $itmId?>">
              </td>
              <td style="text-align:right"><?php echo number_format($item->getPrice(), 2, '.', ',') ?></td>
              <?php
              foreach(self::$currencyRates as $key=>$value) {
                echo '<TD style="text-align:right">'.number_format($item->getPrice()*$value, 2, '.', ',').'</TD>';
              }?>
              <td><input type="text" name="itemQtty<?php echo $itmId?>" id="itemQtty<?php echo $itmId?>" size="5" required="required" value=0>
                  <input type="hidden" id="itemPrice<?php echo $itmId?>" name="itemPrice<?php echo $itmId?>" value="<?php echo $item->getPrice()?>"></td>
              <?php 
              echo '<td class="centerTxt"><a href="'.$_SERVER['PHP_SELF'].'?action='.ACTION_DELETE_ITEM.'&cstId='.$cst->getCustomerID().'&itemId='.$itmId.'">
                     <img src="'.DELETE_ICON.'" alt="Delete"></a></td>';
              echo '<td class="centerTxt"><a href="'.$_SERVER['PHP_SELF'].'?action='.ACTION_EDIT_ITEM.'&cstId='.$cst->getCustomerID().'&itemId='.$itmId.'">
                     <img src="'.EDIT_ICON.'" alt="Edit"></a></td>';
              ?>
            <tr>
          <?php } ?>  
            <tr>
              <td><input type="submit" value="Put Order"  class="btn btn-primary" ></td>
              <td></td>
              <td></td>
              <td></td>
              <td><input type="button" value="List Customers"  class="btn btn-primary" onclick=document.location="<?php echo $_SERVER["PHP_SELF"]."?action=".ACTION_LIST_CUSTOMER; ?>"></td>
            </tr>            
          </table>
          <input type="hidden" id="action" name="action" value="<?php echo ACTION_INSERT_ORDER;?>">      
          <input type="hidden" id="cstId" name="cstId" value="<?php echo $cst->getCustomerID(); ?>">    
        </fieldset>
      </form>
      </div>
    </div>
    <?php 
  }

  //Display form  Item
  static function showFormItem(Item $item, $cstId, $action){ 
    //This form is used for updating an existing item 
    //  and for creating a new one
    ?>
   <div class="container"> 
   <div class="jumbotron">
    <?php
      
      
      //setup action title
      if($action == ACTION_EDIT_ITEM) {
        echo '<p><h3>Edit Item - '.$item->getItemID().'</h3></p>';
      } else {
        echo '<p><h3>Add Item</h3></p>';
      }
      ?>
  
      <form name="formItem" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" >
        <fieldset>
          <table>
            <colgroup>
              <col class="first" />
              <col class="second" />
            </colgroup>
            <tr>
              <td>Description</td>
              <td><input type="text" name="itemDesc" id="itemDesc" size="100" required="required" 
                    value="<?php if($action == ACTION_EDIT_ITEM) { echo $item->getDescription(); } ?>"></td>
            </tr>	
            <tr>
              <td>Price</td>
              <td><input type="text" name="itemPrice" id="itemPrice" size="5" required="required" 
                    value="<?php if($action == ACTION_EDIT_ITEM) { echo $item->getPrice(); } ?>"></td>
            </tr>	
            <tr>
              <td><input type="submit" value="Save"  class="btn btn-primary" ></td>
              <td><input type="button" value="Cancel"  class="btn btn-primary" 
                onclick=document.location="<?php echo $_SERVER["PHP_SELF"]."?action=".ACTION_LIST_ITEMS."&cstId=".$cstId; ?>"></td>
            </tr>
          </table>
          <input type="hidden" id="action" name="action" value="<?php 
                  if($action == ACTION_NEW_ITEM) {
                    echo ACTION_INSERT_ITEM; 
                  } else if ($action == ACTION_EDIT_ITEM){
                    echo ACTION_UPDATE_ITEM;
                  } ?>">      
          <input type="hidden" id="cstId" name="cstId" value="<?php echo $cstId; ?>">    
          <input type="hidden" id="itemId" name="itemId" value="<?php if($action == ACTION_EDIT_ITEM) { echo $item->getItemID(); } ?>"> 
        </fieldset>
      </form>
      </div>
    </div>
    <?php }

  
  // List Orders
  static function listOrders($orders, $items, $customer)   { ?>
  
   <div class="container"> 
   <div class="jumbotron">
    
    <!-- define table style -->
    <style> 
        table { width: 100%; margin: auto; } 
    </style> 
    <TABLE class="table-striped">
        <TR>
            <TH>N# Order</TH>
            <TH>Item Description</TH>
            <TH>Quantity</TH>
            <TH>Total (CAD$)</TH>
            <?php
              foreach(self::$currencyRates as $key=>$value) {
              echo '<TH>('.$key.')</TH>';
            }?>
            <TH class="centerTxt">Delete</TH>
        </TR>

        <?php
        
          echo '<p><h3>'.$customer->getFirstName().' '.$customer->getLastName().' - Order List</h3></p>';

          foreach ($orders as $ord) {
            
            $itemDesc = "";
            $itemId = 0;
            foreach($items as $itm) {
              if ($ord->getItemId() == $itm->getItemId()) {
                $itemDesc = $itm->getDescription();
                $itemId = $itm->getItemID();
                break;
              }
            }
          

            echo '<TR>
              <TD>'.$ord->getOrderID().'</TD>
              <TD>'.$itemDesc.'</TD>
              <TD>'.$ord->getQtty().'</TD>
              <TD>'.number_format($ord->getTotal(), 2, '.', ',').'</TD>';
              
              foreach(self::$currencyRates as $key=>$value) {
                echo '<TD>'.number_format($ord->getTotal()*$value, 2, '.', ',').'</TD>';
              }
              echo '<TD class="centerTxt"><a href="'.$_SERVER['PHP_SELF'].'?action='.ACTION_DELETE_ORDER.'&cstId='.$customer->getCustomerID().'&orderId='.$ord->getOrderID().'&itemId='.$itemId.'">
                     <img src="'.DELETE_ICON.'" alt="Delete"></a></TD>
            </TR>';
          }
        ?>
    </TABLE>

    <p><input type="button" value="List Customers"  class="btn btn-primary" 
        onclick=document.location="<?php echo $_SERVER["PHP_SELF"]."?action=".ACTION_LIST_CUSTOMER; ?>"></p>
    <p><input type="button" value="New Order"  class="btn btn-primary" 
        onclick=document.location="<?php echo $_SERVER["PHP_SELF"]."?action=".ACTION_LIST_ITEMS."&cstId=".$customer->getCustomerID(); ?>"></p>
    </div>
    </div>
    <?php }    
    
      
  // Customer List - Email Search Form
  static function emailSearchForm(String $email = null){ 
    //This form is used for searching customer emails on the customer list. 
    
      ?>
      <div class="container"> 
      <!-- <div class="jumbotron"> -->
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
     
      <form name="emailSearchForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
      <div class="row">
      <div class="col-sm-4"> <p><h3 >Search by:</h3></p> </div>
      </div>
      
            <div class="row">
            <div class="col-sm-1"><strong>Email:</strong></div>
            <div class="col-sm-8"><input type="search" name="cstEmail" id="cstEmail" size="48" 
              value="<?php echo $email; ?>" placeholder = "example@example.com"></div>
            <div class="col-sm-3"><input type="submit" value="Search"  class="btn btn-info btn-sm" ></div>
          </div>
      </nav>
      <br>     
      <input type="hidden" id="action" name="action" value="<?php echo ACTION_SEARCH_CUSTOMER;?>">
      </form>
      </div>
    </div>
   <?php }


  // Orders per Customer Search Form
  static function orderSearchForm($cstId, $itemDesc = "", $cstOrder = ""){ 
    //This form is used for searching customer orders. 
    
      ?>
      <div class="container"> 
      <!-- <div class="jumbotron"> -->
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
     
      <form name="orderSearchForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
      <div class="row">
      <div class="col-sm-6"> <p><h3>Search by:</h3></p> </div>
      </div>
      
          <div class="row">
            <div class="col-sm-2"><strong>Order N# :</strong></div>
            <div class="col-sm-10"><input type="search" name="cstOrder" id="cstOrder" size="10" 
              value="<?php echo $cstOrder; ?>" placeholder = "00"></div>
          </div>
          <div class="row">
              <div class="col-sm-2"><strong>Item Description:</strong></div>
              <div class="col-sm-10"><input type="search" name="itemDesc" id="itemDesc" size="100" 
                value="<?php echo $itemDesc; ?>" placeholder = "Description"></div>
          </div>
          <div class="row">
              <div class="col-sm-2"><input type="submit" value="Search"  class="btn btn-info btn-sm" >
          </div>
         
      </nav>
      <br>     
      <input type="hidden" id="action" name="action" value="<?php echo ACTION_SEARCH_ORDER;?>">
      <input type="hidden" id="cstId"  name="cstId"  value="<?php echo $cstId; ?>">
      </form>
      </div>
    </div>
   <?php }


   // Item Search Form
  static function itemSearchForm($cstId, String $itemDesc = null){ 
    //This form is used for searching customer emails on the customer list. 
    
      ?>
      <div class="container"> 
      <!-- <div class="jumbotron"> -->
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
     
      <form name="itemSearchForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
      <div class="row">
      <div class="col-sm-6"> <p><h3>Search by:</h3></p> </div>
      </div>
      
            <div class="row">
              <div class="col-sm-2" ><strong>Item Description: </strong></div>
              <div class="col-sm-10" ><input type="search" name="itemDesc" id="itemDesc" size="100"  
                value="<?php echo $itemDesc; ?>" placeholder = "Description"></div>
            </div>
            <div class="row">
              <div class="col-sm-2"><input type="submit" value="Search"  class="btn btn-info btn-sm" ></div>
          </div>
         
      </nav>
      <br>     
      <input type="hidden" id="action" name="action" value="<?php echo ACTION_SEARCH_ITEM;?>">
      <input type="hidden" id="cstId" name="cstId" value="<?php echo $cstId; ?>"> 
      </form>
      </div>
    </div>
   <?php }

}