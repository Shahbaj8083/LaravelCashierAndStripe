<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;
use Stripe\Charge;
use Stripe\Invoice;
use Stripe\InvoiceItem;
use Illuminate\Support\Facades\Log;


class StripePaymentController extends Controller
{
    /**
     * Show the payment form.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $request)
    {
        $name = $request->input('name');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $bill = $request->input('bill');

        return view('stripe', compact('name', 'phone', 'address', 'bill'));
    }

    /**
     * Process the payment and create an order.
     *
     * @return \Illuminate\Http\Response
     */
    // public function singleCharge(Request $request)
    // {
    //     $amount = $request->amount;
    //     $amount = $amount * 100;
    //     $paymentMethod = $request->payment_method;

    //     $user = auth()->user();
    //     $user->createOrGetStripeCustomer();

    //     if ($paymentMethod != null) {
    //         $paymentMethod = $user->addPaymentMethod($paymentMethod);
    //     }

    //     $user->charge($amount, $paymentMethod);

    //     return to_route('home');
    // }
    public function stripePost(Request $request)
    {
        try {
            // Set Stripe API key from environment
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Create a charge
            $charge = Charge::create([
                "amount" => $request->input('bill') * 100,
                "currency" => " usd ",
                "source" => $request->stripeToken,
                "description" => "New order payment received successfully"
            ]);

            // Handle successful payment
            if ($charge->status === 'succeeded') {
                // Create an order
                $order = new Order();
                $order->status = "paid"; // Initial status is paid
                $order->customer_id = auth()->user()->id;
                $order->bill = $request->input('bill');
                $order->name = $request->input('name');
                $order->phone = $request->input('phone');
                $order->address = $request->input('address');

                if ($order->save()) {
                    // Move cart items to order items
                    $cartItems = Cart::where('customer_id', auth()->user()->id)->get();

                    foreach ($cartItems as $item) {
                        $product = Product::find($item->product_id);

                        $orderItem = new OrderItem();
                        $orderItem->product_id = $item->product_id;
                        $orderItem->quantity = $item->quantity;
                        $orderItem->order_id = $order->id;
                        $orderItem->price = $product->price;
                        $orderItem->save();

                        // Remove cart item after checkout
                        $item->delete();
                    }
                }

                // Create invoice (optional, based on your business logic)
                $this->createInvoice($request);

                return redirect('/cart')->with('success', 'Your order has been placed successfully!');
            } else {
                return redirect('/cart')->with('error', 'Payment failed!');
            }
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return redirect('/cart')->with('error', 'An error occurred while processing your order: ' . $e->getMessage());
        }
    }

    /**
     * Create an invoice for the customer.
     *
     * @param Request $request
     * @return void
     */
    public function createInvoice(Request $request)
    {
        try {
            // Set Stripe API key from environment
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Example: Create an invoice item (optional)
            $customerId = $request->user()->stripe_id; // Replace with actual Stripe customer ID
            InvoiceItem::create([
                'customer' => $customerId,
                'amount' => $request->input('bill') * 100, // Amount in cents
                'currency' => 'usd',
                'description' => 'One-time fee for service',
            ]);

            // Example: Create an invoice (optional)
            Invoice::create([
                'customer' => $customerId,
            ]);

            // Handle invoice creation and other logic here
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Error creating invoice: ' . $e->getMessage());
        }
    }
}
