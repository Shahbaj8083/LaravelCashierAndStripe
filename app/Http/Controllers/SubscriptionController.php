<?php

namespace App\Http\Controllers;

use App\Models\Plan as ModelsPlan;
use Exception;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Stripe\Plan;
use Stripe;


class SubscriptionController extends Controller
{
    public function showPlanForm()
    {
        return view('plans.createPlan');
    }
    public function savePlan(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $amount = ($request->amount * 100);
        try {
            $plan = Plan::create([
                'amount' => $amount,
                'currency' => $request->currency,
                'interval' => $request->billing_period,
                'interval_count' => $request->interval_count,
                'product' => [
                    'name' => $request->name
                ]
            ]);


            ModelsPlan::create([
                'plan_id' => $plan->id,
                'name' => $request->name,
                'price' => $plan->amount,
                'billing_method' => $plan->interval,
                'currency' => $plan->currency,
                'interval_count' => $plan->interval_count
            ]);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }

        return "success";
    }
    public function allPlans()
    {
        $basic = ModelsPlan::where('name', 'basic')->first();
        $professional = ModelsPlan::where('name', 'professional')->first();
        $enterprise = ModelsPlan::where('name', 'enterprise')->first();
        return view('plans', compact('basic', 'professional', 'enterprise'));
    }


    public function checkout($planId)
    {
        $plan = ModelsPlan::where('plan_id', $planId)->first();

        if (!$plan) {
            return back()->withErrors([
                'message' => 'Unable to locate the plan'
            ]);
        }

        $user = auth()->user();
        if (!$user) {
            return back()->withErrors([
                'message' => 'You must be logged in to proceed'
            ]);
        }

        # Create a setup intent for the authenticated user
        $intent = $user->createSetupIntent();

        # Return the checkout view with the plan and setup intent
        return view('plans.checkout', [
            'plan' => $plan,
            'intent' => $intent,
        ]);
    }

    public function processPlan(Request $request)
    {
        $user = auth()->user();
        $user->createOrGetStripeCustomer();
        $paymentMethod = null;
        $paymentMethod = $request->payment_method;
        if ($paymentMethod != null) {
            $paymentMethod = $user->addPaymentMethod($paymentMethod);
        }
        $plan = $request->plan_id;

        try {
            $user->newSubscription(
                'default',
                $plan
            )->create($paymentMethod != null ? $paymentMethod->id : '');
        } catch (Exception $ex) {
            return back()->withErrors([
                'error' => 'Unable to create subscription due to this issue ' . $ex->getMessage()
            ]);
        }

        $request->session()->flash('alert-success', 'You are subscribed to this plan');
        return to_route('plans.checkout', $plan);
    }
}
