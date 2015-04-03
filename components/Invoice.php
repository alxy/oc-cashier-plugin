<?php namespace Alxy\Cashier\Components;

use Cms\Classes\ComponentBase;
use Auth;
use Alxy\Cashier\Models\InvoiceTemplate;

class Invoice extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Invoice Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        if( ! $user = Auth::getUser())
            return;

        $invoice = $user->invoices()[0];
        $template = InvoiceTemplate::find(1)->renderInvoice($invoice);
//        dd($invoice);
        return $template;
//        dd($invoices);
        return $user->downloadInvoice("in_15h9Zh4iqtt0IUyqynuNhSLp", [
            'vendor'  => 'Your Company',
            'product' => 'Your Product',
        ]);
    }

}