<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscriptions\StoreSubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::with('user')->wherePaid(1)->get()
            ->map(function($subscription) {
                $user = $subscription->user;
                if($user->role == 'office') {
                    $name = $user->office->name;
                    $image = $user->office->logo_url;
                } else {
                    $name = $user->general_user->fullname;
                    $image = $user->general_user->image_url;
                }
                return [
                    'id' => $subscription->id,
                    'name' => $name,
                    'image' => $image,
                    'package_name' => json_decode($subscription->values)->name,
                    'total' => $subscription->total,
                    'date' => $subscription->date
                ];
            });
        return $this->generalResponse($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request)
    {
        return $request->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        // $status = $request->validate(['status' => ['required', 'in:active,inactive']])['status'];
        // $subscription->status = $status;
        // $subscription->save();
        return $this->generalResponse(null, null, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
