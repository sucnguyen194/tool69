<?php

namespace App\Http\Controllers\Gateway\NganLuong;

include 'lib/nganluong.class.php';

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\NL_Checkout;
use Illuminate\Http\Request;

class ProcessController extends Controller {

    public static function process($deposit){
        $basic =  GeneralSetting::first();

        $gateway_currency = $deposit->gatewayCurrency();

        $user = auth()->user();

        $account = json_decode($gateway_currency->gateway_parameter);

        //Mã đơn hàng
        $order_code='NL_'.time();
        $return_url=  route(gatewayRedirectUrl(true));
        $cancel_url= $_SERVER['HTTP_REFERER'];
        $notify_url = route(gatewayRedirectUrl(true));
        $txh_name = $user->last_name.' '.$user->first_name;
        $txt_email = $user->email;
        $txt_phone = $user->phone;
        $price = (int) $deposit->final_amo;
        $transaction_info="Thong tin giao dich";
        $currency= "vnd";
        $quantity=1;
        $tax=0;
        $discount=0;
        $fee_cal=0;
        $fee_shipping=0;
        $order_description="Thong tin don hang: ".$order_code;
        $buyer_info=$txh_name."*|*".$txt_email."*|*".$txt_phone;
        $affiliate_code="";

        $receiver= $account->receiver;

        $nl= new NL_Checkout();
        $nl->nganluong_url = 'https://www.nganluong.vn/checkout.php';
        $nl->merchant_site_code =  $account->merchant_code;
        $nl->secure_pass =  $account->merchant_pass;

        //Tạo link thanh toán đến nganluong.vn
        $url= $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount , $fee_cal,   $fee_shipping, $order_description, $buyer_info , $affiliate_code);
        //$url= $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);

        if ($order_code != "") {
            //một số tham số lưu ý
            //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
            //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
            $url .='&cancel_url='. $cancel_url . '&notify_url='.$notify_url;
            //$url .='&option_payment=bank_online';
//
//            echo '<meta http-equiv="refresh" content="0; url='.$url.'" >';
//            //&lang=en --> Ngôn ngữ hiển thị google translate
        }

        $send['val'] = [];
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'post';
        $send['url'] = $url;

        return json_encode($send);
    }

    public function ipn(Request $request){

        if($request->get('payment_id')){

            $transaction_info = $request->get('transaction_info');
            $order_code = $request->get('order_code');
            $price = $request->get('price');
            $payment_id = $request->get('payment_id');
            $payment_type = $request->get('payment_type');
            $error_text = $request->get('error_text');
            $secure_code = $request->get('secure_code');


            $deposit = Deposit::where('trx', $payment_id)->orderBy('id', 'DESC')->first();
            $account = json_decode($deposit->gatewayCurrency()->gateway_parameter);

            //Khai báo đối tượng của lớp NL_Checkout
            $nl= new NL_Checkout();
            $nl->merchant_site_code = $account->merchant_code;
            $nl->secure_pass = $account->merchant_pass;

            //Tạo link thanh toán đến nganluong.vn
            $checkpay= $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);

            if ($checkpay) {
//                echo 'Payment success: <pre>';
                // bạn viết code vào đây để cung cấp sản phẩm cho người mua

                PaymentController::userDataUpdate($deposit->trx);
            }else{
                echo "payment failed";
            }
        }

    }
}

?>
