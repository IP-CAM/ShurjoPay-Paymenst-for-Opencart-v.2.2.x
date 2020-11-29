<?php

/**
 * Created by PhpStorm.
 * User: nadim
 * Date: 5/10/16
 * Time: 11:27 AM
 */
class ControllerPaymentShurjopay extends Controller {


    public function index()
    {
        $this->load->model('checkout/order');

        $this->load->language('payment/shurjopay');

        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['action'] = $this->url->link('payment/shurjopay/curl');

        $data['pay_to_username'] = $this->config->get('shurjopay_username');
        $data['pay_to_password'] = $this->config->get('shurjopay_password');
        $data['uniq_transaction_key'] = $this->config->get('shurjopay_uniq_transaction_key');
        $data['userIP'] = $this->config->get('shurjopay_userIP');
        $data['paymentOption'] = $this->config->get('shurjopay_paymentOption');
        $data['returnUrl'] = $this->url->link('payment/shurjopay/callback');
        $data['platform'] = '31974336';
        $data['description'] = $this->config->get('config_name');
        $data['transaction_id'] = $this->session->data['order_id'];
        $data['return_url'] = $this->url->link('checkout/success');
        $data['cancel_url'] = $this->url->link('checkout/checkout', '', true);

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        /*$data['pay_from_email'] = $order_info['email'];
        $data['firstname'] = $order_info['payment_firstname'];
        $data['lastname'] = $order_info['payment_lastname'];
        $data['address'] = $order_info['payment_address_1'];
        $data['address2'] = $order_info['payment_address_2'];
        $data['phone_number'] = $order_info['telephone'];
        $data['postal_code'] = $order_info['payment_postcode'];
        $data['city'] = $order_info['payment_city'];
        $data['state'] = $order_info['payment_zone'];
        $data['country'] = $order_info['payment_iso_code_3'];*/
        $data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['currency'] = $order_info['currency_code'];

        $products = '';

        foreach ($this->cart->getProducts() as $product) {
            $products .= $product['quantity'] . ' x ' . $product['name'] . ', ';
        }

        $data['detail1_text'] = $products;

        $data['order_id'] = $this->session->data['order_id'];
        return $this->load->view('default/template/payment/shurjopay.tpl', $data);
    }

    /* callback for data */
    public function callback()
    {
        $this->load->model('checkout/order');
        if(count($_POST)>0) {
            $response_encrypted = $_POST['spdata'];
            $response_decrypted = file_get_contents("https://shurjopay.shurjorajjo.com.bd/merchant/decrypt.php?data=".$response_encrypted);
            $data= simplexml_load_string($response_decrypted) or die("Error: Cannot create object");

            /*$tx_id = $data->txID;
            $bank_tx_id = $data->bankTxID;
            $bank_status = $data->bankTxStatus;
            $sp_code = $data->spCode;
            $sp_code_des = $data->spCodeDes;
            $sp_payment_option = $data->paymentOption;*/
            $tx['txid'] = $data->txID;
            $tx['bankTxID'] = $data->bankTxID;
            $tx['bankTxStatus'] = $data->bankTxStatus;
            $sp_code = $data->spCode;
            $tx['spCode'] = $data->spCode;
            $tx['spCodeDes'] = $data->spCodeDes;
            $tx['paymentOption'] = $data->paymentOption;
            $order_id = $this->session->data['order_id'];
            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('config_order_status_id'));

            switch($sp_code) {
                case '000':
                    $res = array('status'=>true,'msg'=>'success');
                    break;
                case '100':
                    $res = array('status'=>false,'msg'=>'Transaction Decline');
                    break;
                case '109':
                    $res = array('status'=>false,'msg'=>'Invalid Merchant');
                    break;
                case '201':
                    $res = array('status'=>false,'msg'=>'Card Expired');
                    break;
                case '202':
                    $res = array('status'=>false,'msg'=>'Suspected Fraud');
                    break;
                case '300':
                    $res = array('status'=>false,'msg'=>'Action Successful');
                    break;
                case '304':
                    $res = array('status'=>false,'msg'=>'File Edit Error');
                    break;
                case '700':
                    $res = array('status'=>false,'msg'=>'Accepted');
                    break;
                case '096':
                    $res = array('status'=>false,'msg'=>'Transaction Failed');
                    break;
                case '601':
                    $res = array('status'=>false,'msg'=>'Transaction not permitted to cardholder');
                    break;
                case '603':
                    $res = array('status'=>false,'msg'=>'Invalid Card number');
                    break;
                default:
                    $res = array('status'=>false,'msg'=>'Unknow Error Occured.');
                    break;
            }
            if($res['status']) {
                $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('shurjopay_order_status_id'), '', true);
                echo '<html>' . "\n";
                echo '<head>' . "\n";
                echo '  <meta http-equiv="Refresh" content="0; url=' . $this->url->link('checkout/success') . '">' . "\n";
                echo '</head>' . "\n";
                echo '<body>' . "\n";
                echo '  <p>Success!!!Please follow <a href="' . $this->url->link('checkout/success') . '">link</a>!</p>' . "\n";
                echo '</body>' . "\n";
                echo '</html>' . "\n";
                exit();
                //echo "Success";
                die();
            } else {
                print_r($res);
                echo "<br>Fail"; //header("location:".$failed_url."?status=failed&msg=".$res['msg']."&id=".$tx_id);
                die();
            }
        }
    }
    /* end callback */
    public function curl()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST'){
            $ch = curl_init();
            /*$this->request->post['pay_to_username']
            $this->request->post['pay_to_password']
            $this->request->post['uniq_transaction_key']
            $this->request->post['userIP']
            $this->request->post['paymentOption']
            $this->request->post['returnUrl']*/
            $xml_data = 'spdata=<?xml version="1.0" encoding="utf-8"?>
                            <shurjoPay><merchantName>'.$this->request->post['pay_to_username'].'</merchantName>
                            <merchantPass>'.$this->request->post['pay_to_password'].'</merchantPass>
                            <userIP>'.$this->request->post['userIP'].'</userIP>
                            <uniqID>'.$this->request->post['uniq_transaction_key'].'</uniqID>
                            <totalAmount>'.$this->request->post['amount'].'</totalAmount>
                            <paymentOption>'.$this->request->post['paymentOption'].'</paymentOption>
                            <returnURL>'.$this->request->post['returnUrl'].'</returnURL></shurjoPay>';
            $url = "https://shurjopay.shurjorajjo.com.bd/sp-data.php";
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
            curl_setopt($ch,CURLOPT_POSTFIELDS,$xml_data);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            print_r($response);
            curl_close ($ch);
        }
    }
    //end of curl
}
?>