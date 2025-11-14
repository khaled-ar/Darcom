<?php

namespace App\Http\Requests\Subscriptions;

use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['office', 'general_user']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'package_id' => ['required', 'integer', 'exists:packages,id']
        ];
    }

    public function store() {
        $package = Package::whereId($this->package_id)->first();
        $user = $this->user();
        $current_subscription = $user->subscription ?? null;
        if($current_subscription) {
            $values = json_decode($current_subscription->values);

            // if($values->id == $package->id) {
            //     return $this->generalResponse(null, 'error_unique', 400);
            // }

            $package->posts_number += $values->posts_number;
            $package->images_number += $values->images_number;
            $package->videos_number += $values->videos_number;
            $package->featured_posts_number += $values->featured_posts_number;
            $package->posts_requests_number += $values->posts_requests_number;
            $package->posts_notifications_number += $values->posts_notifications_number;

            $user->subscription()->update([
                'package_id' => $package->id,
                'total' => $package->price + $current_subscription->total,
                'expire_at' => now()->addDays($package->validity),
                'values' => json_encode($package)
            ]);

        } else {
            $data = [
                'user_id' => $user->id,
                'package_id' => $package->id,
                'total' => $package->price,
                'expire_at' => now()->addDays($package->validity),
                'values' => $package,
            ];
            Subscription::create($data);
        }

        return $this->generalResponse(null, 'The request has been sent to the manager successfully.', 200);
    }
}
