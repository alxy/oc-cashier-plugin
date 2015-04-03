<?php namespace Alxy\Cashier\Components;

use Cms\Classes\ComponentBase;
use RainLab\User\Models\User;
use Auth;

class SubscriptionForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'SubscriptionForm Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $this->addJs('https://js.stripe.com/v2/');
        $this->addJs('http://cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.min.js');
        $this->addJs('/plugins/alxy/cashier/assets/js/payment-form.js');
        $this->addCss('/plugins/alxy/cashier/assets/css/payment-form.css');
    }

    public function onSubscribe() {
        if( ! $user = Auth::getUser())
            return;
        $user->subscription(post('subscriptionType'))->withCoupon('code')->create(post('stripeToken'), [
            'email' => $user->email,
            'metadata' => array_only($user->attributes, ['name', 'surname', 'phone', 'company', 'street_addr', 'city', 'zip']),
        ]);
    }

}