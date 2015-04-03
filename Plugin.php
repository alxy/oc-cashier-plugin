<?php namespace Alxy\Cashier;

use App;
use Config;
use System\Classes\PluginBase;
use RainLab\User\Models\User;
use Alxy\Cashier\Models\Settings;

/**
 * Cashier Plugin Information File
 */
class Plugin extends PluginBase
{
   public $require = ['Rainlab.User'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Cashier',
            'description' => 'No description provided yet...',
            'author'      => 'Alxy',
            'icon'        => 'icon-leaf'
        ];
    }

    public function boot()
    {
        App::register('Laravel\Cashier\CashierServiceProvider');

        Config::set('services.stripe.model', 'RainLab\User\Models\User');
        Config::set('services.stripe.secret', Settings::get('stripe_secret'));

        User::extend(function ($model) {
            $model->implement[] = 'Alxy.Cashier.Behaviors.BillableModel';
        });
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Cashier Settings',
                'description' => 'Manage Stripe keys and subscriptions.',
                'category'    => 'rainlab.user::lang.settings.users',
                'icon'        => 'icon-cc-stripe',
                'class'       => 'Alxy\Cashier\Models\Settings',
                'order'       => 500,
                'keywords'    => 'security stripe keys subscriptions billing'
            ],
            'invoices' => [
                'label'       => 'Invoice template',
                'description' => 'Customize the template used for invoices.',
                'icon'        => 'icon-file-excel-o',
                'url'         => \Backend::url('alxy/cashier/invoicetemplates'),
                'category'    => 'rainlab.user::lang.settings.users',
                'order'       => 500,
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'Alxy\Cashier\Components\SubscriptionForm' => 'subscriptionForm',
            'Alxy\Cashier\Components\Invoice' => 'invoice',
        ];
    }

}
