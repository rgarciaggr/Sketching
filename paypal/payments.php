<?php
/**
 * Created by PhpStorm.
 * User: Kuro
 * Date: 13/06/2018
 * Time: 12:05
 */


include_once '../persistencia/PagoDAO.php';
include_once '../persistencia/SubsDAO.php';
include_once '../persistencia/UsuarioDAO.php';
include_once '../objetos/Usuario.php';
include_once '../objetos/Subs.php';
include_once '../objetos/Pago.php';

// PayPal settings
$item_name = $_POST['item_name'];
$item_amount = $_POST['item_number'];
$autorId = explode(' ', $_POST['custom']);


$paypal_email = 'robert5_gg-facilitator@hotmail.com';
$return_url = 'http://sketching.sytes.net/interfaz/privado/Subscribe';
$cancel_url = 'http://sketching.sytes.net';
$notify_url = 'http://sketching.sytes.net/paypal/payments';




// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
    $querystring = '';

    // Firstly Append paypal account to querystring
    $querystring .= "?business=".urlencode($paypal_email)."&";

    // Append amount& currency (£) to quersytring so it cannot be edited in html

    //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
    $querystring .= "item_name=".urlencode($item_name)."&";
    $querystring .= "amount=".urlencode($item_amount)."&";

    //loop for posted values and append to querystring
    foreach($_POST as $key => $value){
        $value = urlencode(stripslashes($value));
        $querystring .= "$key=$value&";
    }

    // Append paypal return addresses
    $querystring .= "return=".urlencode(stripslashes($return_url))."&";
    $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
    $querystring .= "notify_url=".urlencode($notify_url);

    // Append querystring with custom field
    //$querystring .= "&custom=".USERID;

    // Redirect to paypal IPN
    header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
    exit();
} else {
    // Response from Paypal
    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
        $req .= "&". $key ."=".$value;
    }

    // assign posted variables to local variables
    $data['item_name']          = $_POST['item_name'];
    $data['item_number']        = $_POST['item_number'];
    $data['payment_status']     = $_POST['payment_status'];
    $data['payment_amount']     = $_POST['mc_gross'];
    $data['payment_currency']   = $_POST['mc_currency'];
    $data['txn_id']             = $_POST['txn_id'];
    $data['receiver_email']     = $_POST['receiver_email'];
    $data['payer_email']        = $_POST['payer_email'];
    $data['custom']             = $_POST['custom'];

    // post back to PayPal system to validate
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);


    if (!$fp) {
        // HTTP ERROR
    } else {
        fputs($fp, $header . $req);
        $aux = true;
        while (!feof($fp)) {
            $res = fgets ($fp, 1024);
            //mail('postmaster@sketching.sytes.net', 'PAYPAL POST ', print_r($res, true));
            //if (strcmp($res, "VERIFIED") == 0) {
                // Used for debugging
                // mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));

                // Validate payment (Check unique txnid & correct price)
                //$valid_txnid = check_txnid($data['txn_id']);
                //$valid_price = check_price($data['payment_amount'], $data['item_number']);
                // PAYMENT VALIDATED & VERIFIED!
                //if ($valid_txnid && $valid_price) {
            if(isset($data['txn_id']) && $aux){


                $subsDao = SubsDAO::singletonSubs();
                $usuarioDao = UsuarioDAO::singletonUsuario();
                $pagoDao = PagoDAO::singletonPago();


                $arrayIds = explode(' ', $data['custom']);

                $suscrito = $subsDao->getSubByUserAndAutor($arrayIds[0], $arrayIds[1]);


                if($suscrito !== null){
                    $subsDao->updateSub($arrayIds[0], $arrayIds[1], $data['item_number']);
                }else{
                    $subsDao->addSub($arrayIds[0], $arrayIds[1], $data['item_number']);
                }
                $orderid = $pagoDao->addPago($arrayIds[0], $arrayIds[1], 'pending', $data['item_number']);

                    if ($orderid) {
                        // Payment has been made & successfully inserted into the Database
                        mail('postmaster@sketching.sytes.net', 'PAYPAL POST - DESPUES', print_r($data, true));
                    } else {
                        // Error inserting into DB
                        // E-mail admin or alert user
                        mail('postmaster@sketching.sytes.net', 'PAYPAL POST - INSERT INTO DB WENT WRONG', print_r($data, true));
                    }
                //} else {
                    // Payment made but data has been changed
                    // E-mail admin or alert user
                //}
                header("HTTP 200 OK");
                    $aux = false;
            }

            /*} else if (strcmp ($res, "INVALID") == 0) {

                // PAYMENT INVALID & INVESTIGATE MANUALY!
                // E-mail admin or alert user

                // Used for debugging
                //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response
                $data ="<pre>".print_r($post, true)."</pre>";
            }*/
        }
        fclose ($fp);
    }
}