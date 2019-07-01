<?php

namespace App\Http\Controllers;

use App\models\Safmpesa;
use Illuminate\Http\Request;
// use SmoDav\Mpesa\Laravel\Facades\Registrar;
// use SmoDav\Mpesa\Laravel\Facades\Simulate;
// use SmoDav\Mpesa\Laravel\Facades\STK;

class SafmpesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Safmpesa  $safmpesa
     * @return \Illuminate\Http\Response
     */
    public function show(Safmpesa $safmpesa)
    {
        //
    }

    // public function register_url(Safmpesa $safmpesa)
    // {
    //     $conf = 'http://shop.speedballcourier.com/confirm?secret=SlpVRzFDWTZlYnJaV3ZWUmxlcEFUN2RXS0dGdHBRYzI6Z0NVeWJCMUIzdnhsd2gxOA==';
    //     $val = 'http://shop.speedballcourier.com/validate?secret=SlpVRzFDWTZlYnJaV3ZWUmxlcEFUN2RXS0dGdHBRYzI6Z0NVeWJCMUIzdnhsd2gxOA==';
    //     $response = Registrar::register(600000)
    //         ->onConfirmation($conf)
    //         ->onValidation($val)
    //         ->submit();
    // }

    // public function simulatePay()
    // {
    //     $response = Simulate::request(10)
    //         ->from(254708374149)
    //         ->usingReference('some reference')
    //         ->setCommand(CUSTOMER_PAYBILL_ONLINE)
    //         ->push();
    // }

    // public function stkPush()
    // {
    //     $response = STK::request(10)
    //         ->from(254708374149)
    //         ->usingReference('some reference', 'Test Payment')
    //         ->push();

    // }

    // public function validate()
    // {
    //     $response = STK::validate('ws_CO_16022018125');
    // }

    public function register_url()
    {
        $BusinessShortCode = '174379';
        $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType = '';
        $Amount = '50';
        $PartyA = '';
        $PartyB = '';
        $PhoneNumber = '254708374149';
        $CallBackURL = 'http://shop.speedballcourier.com/callback?secret=SlpVRzFDWTZlYnJaV3ZWUmxlcEFUN2RXS0dGdHBRYzI6Z0NVeWJCMUIzdnhsd2gxOA==';
        $AccountReference = '';
        $TransactionDesc = '';
        $Remarks = 'some remark';
        $mpesa= new \Safaricom\Mpesa\Mpesa();
        return $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks);
    }

    public function mpesapay()
    {
        $request = mpesa_request('0743895505',1,'reference','description');
    }
}
