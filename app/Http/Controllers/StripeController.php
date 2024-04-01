<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\RateLimitException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;



class StripeController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }
    public function handleCardDeclined()
    {
        return view('card_declined');
    }

    public function success()
    {
        return view('paymentsuccess');
    }

    public function processPayment(Request $request)
    {


        try {
            \Stripe\Stripe::setApiKey(config('stripe.sk'));
            // Create a PaymentIntent with a test token
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->total * 100, // amount in cents
                'currency' => 'usd',
                'payment_method_types' => ['card'],
                'description' => $request->productname,
                'confirm' => true,
                'confirmation_method' => 'manual',
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $request->stripeToken,
                    ],
                ],
            ]);
            // dd(     $paymentIntent);
            // Payment succeeded
            return redirect()->route('payment.success');
        } catch (CardException $e) {
            $error = $e->getMessage();
            // Log the exception or handle it as needed
            // return Redirect::route('card.declined')->withErrors(['message' => 'Card was declined.']);
        } catch (InvalidRequestException | AuthenticationException | ApiConnectionException | RateLimitException $e) {
            $error = $e->getMessage();

            // Other Stripe API exceptions
            // return back()->withErrors(['message' => 'Payment failed. Please try again later.']);
        } catch (ApiErrorException $e) {
            $error = $e->getMessage();
            // Handle generic API errors
            // return back()->withErrors(['message' => 'Payment failed. Please try again later.']);
        }


        // Pass error message to the view
        return View::make('payment-failed', ['error' => $error]);
    }



}
