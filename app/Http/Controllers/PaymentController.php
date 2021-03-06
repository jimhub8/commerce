<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Payment;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\Cart;
use App\Order;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;
use App\models\Product;
use App\models\Sale;
use App\models\CurrencyConversion;
use App\models\AutoGenerate;

class PaymentController extends Controller
{
    public function __construct()
    { }

    public function create(Request $request)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_ID'),     // ClientID
                env('PAYPAL_SECRETE')      // ClientSecret
            )
        );
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        // $item1 = new Item();
        // $item1->setName('Ground Coffee 40 oz')
        //     ->setCurrency('USD')
        //     ->setQuantity(1)
        //     ->setSku("123123") // Similar to `item_number` in Classic API
        //     ->setPrice(7.5);
        // $item2 = new Item();
        // $item2->setName('Granola bars')
        //     ->setCurrency('USD')
        //     ->setQuantity(5)
        //     ->setSku("321321") // Similar to `item_number` in Classic API
        //     ->setPrice(2);
        $items = [];
        $total = 0;
        $tax = 0;
        $shipment = 0;
        $qty = 0;
        $price = 0;
        foreach ($this->getCart() as $cart) {
            $name = $cart['item']['name'];
            $total = $total + ($cart['item']['price'] * $cart['qty']);
            $item = new Item();
            // dd($cart['item']['price']);
            // dd($cart['qty']);
            $qty = $cart['qty'];
            $price = $cart['item']['price'];
            $convert = new CurrencyConversion;
            $price = $convert->convert($price);
            // dd($price);
            $items[] = $item->setName($name)
                ->setCurrency('USD')
                ->setQuantity($qty)
                ->setSku("123123") // Similar to `item_number` in Classic API
                ->setPrice($price);
        }
        // dd($qty);
        // dd($items);

        $tax = $total * 16 / 100;
        $shipment = $total * 1 / 100;
        $subtotal = $total - $tax - $shipment;
        // dd($items);


        $convert = new CurrencyConversion;
        $tax = $convert->convert($tax);
        $shipment = $convert->convert($shipment);
        $subtotal = $convert->convert($subtotal);
        $total = $convert->convert($total);

        // dd($tax + $shipment + $subtotal .  '    total: ' . $total);
        // dd('tax: ' . $tax . '  shipment: ' . $shipment. '  subtotal: ' . $subtotal. '  total: ' . $total);

        $itemList = new ItemList();
        $itemList->setItems($items);
        // $itemList->setItems(array($item1, $item2));
        $details = new Details();
        $details->setShipping($shipment)
            ->setTax($tax)
            ->setSubtotal($total);
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total + $tax + $shipment)
            ->setDetails($details);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        // $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(env('APP_URL') . "/execute-payment")
            ->setCancelUrl(env('APP_URL') . "/paypal");
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        // $request = clone $payment;
        $payment->create($apiContext);
        // dd($apiContext);
        return redirect($payment->getApprovalLink());
        // return $payment;
    }

    public function execute(Request $request)
    {
        // After Step 1


        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_ID'),     // ClientID
                env('PAYPAL_SECRETE')      // ClientSecret
            )
        );

        $total = 0;
        $tax = 0;
        $shipment = 0;
        foreach ($this->getCart() as $cart) {
            $total = $total + ($cart['item']['price'] * $cart['qty']);
        }
        $tax = $total * 16 / 100;
        $shipment = $total * 1 / 100;
        $subtotal = $total - $tax - $shipment;


        $convert = new CurrencyConversion;
        $tax = $convert->convert($tax);
        $shipment = $convert->convert($shipment);
        $subtotal = $convert->convert($subtotal);
        $total = $convert->convert($total);

        $paymentId = $request->paymentId;
        // dd($paymentId);
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $details->setShipping($shipment)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        $amount->setCurrency('USD');
        $amount->setTotal($total + $tax + $shipment);
        $amount->setDetails($details);
        $transaction->setAmount($amount);
        $execution->addTransaction($transaction);
        $result = $payment->execute($execution, $apiContext);
        // dd($total);
        $order = new Order;
        $order->buyer_id = Auth::id();
        // $order->buyer_id = Auth::id();
        $order->payment_id = $payment->id;

        // foreach ($cart as $product) {
        //     $order->company_id = $product['item']['company_id'];
        // }
        $order->address = 'Nairobi';
        $order->status = 'Payed';
        $order->amount = $amount->total;
        $order->name = Auth::user()->name;
        $order->cart = serialize($this->getCart());
        $order->paypal = serialize($payment);
        // $orderSave = Auth::user()->orders()->save();
        $order->save();
        $cart = $this->getCart();
        $this->getCartProduct();
        $user = Auth::user();
        $this->sales('Payed');
        Notification::send($user, new OrderNotification($order, $cart));
        if ($order->save()) {
            $request->session()->forget('cart');
        }
        return redirect('/#/thankyou');
        // Create Orders

        // return $order;
        // return $payment;
        // return $request('paymentId');
    }


    public function cash_delivery(Request $request)
    {
        // return $request->all();
        // dd($this->getCart());
        $order = new Order;
        $order->buyer_id = Auth::id();
        // $order->buyer_id = Auth::id();
        $payment_id = new AutoGenerate;
        $order->payment_id = $payment_id->randomPaymentId();
        // foreach ($cart as $product) {
        //     $order->company_id = $product['item']['company_id'];
        // }
        $order->address = 'Nairobi';
        $order->status = 'Unconfirmed';
        $order->amount = $request->total;
        $order->name = Auth::user()->name;
        $order->cart = serialize($this->getCart());
        // $order->paypal = serialize($payment);
        // $orderSave = Auth::user()->orders()->save();
        $order->save();
        $cart = $this->getCart();
        $this->getCartProduct();
        $user = Auth::user();
        $this->sales('Unconfirmed', $request->all());
        Notification::send($user, new OrderNotification($order, $cart));
        if ($order->save()) {
            $request->session()->forget('cart');
        }
        return $this->returngetCart();
        // return redirect('/#/thankyou');
    }
    public function sales($status, $account)
    {
        // dd($account['payment']);
        $cart = $this->getCart();
        // dd($cart);
        foreach ($cart as $product) {
            $sales = new Sale;
            $sales->product_id = $product['item']['id'];
            $sales->user_id = Auth::id();
            $sales->company_id = $product['item']['company_id'];
            $sales->list_price = $product['item']['list_price'];
            $sales->price = $product['item']['price'];
            $sales->quantity = $product['qty'];
            $sales->total = $product['price'];
            $sales->status = $status;
            $sales->client_name = $account['name'];
            $sales->client_email = $account['email'];
            $sales->client_phone = $account['phone'];
            $sales->client_address = $account['address'];
            $sales->client_city = $account['city'];
            $sales->client_country = $account['country'];
            $sales->payment = $account['payment'];
            $sales->product_name = $product['item']['name'];
            $sales->cart = serialize(Product::find($product['item']['id']));
            $sales->save();
        }
        return $sales;
    }

    public function getCart()
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $carts = new Cart($oldCart);
        $carts = $carts->getCart($oldCart);
        $newCart = [];
        // foreach ($carts as $cart) {
        //     $newCart = $cart->item;
        // }
        return $carts;
    }
    public function returngetCart()
    {
        // dd(Session::get('cart'));
        if (Session::has('cart')) {
            $carts = Session::get('cart');
            $cartA = [];
            foreach ($carts->items as $itemsC) {
                $cartA[] = $itemsC;
            }
            return ($cartA);
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            return $cart->getCart();
        } else {
            return;
        }

        // Get Total if coupons

    }


    public function getCartProduct()
    {
        $cart = $this->getCart();
        foreach ($cart as $product) {
            $cart_id = $product['item']['id'];
            $cart_qty = $product['qty'];
            $product_s = Product::find($cart_id);
            $new_qty = $product_s->quantity - $cart_qty;
            // dd($product_s->quantity .' - '. $cart_qty . ' = '. $new_qty);
            $product = Product::where('id', $cart_id)->update(['quantity' => $new_qty]);
        }
        return $product;
    }
}


