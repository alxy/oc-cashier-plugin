<?php
/**
 * Created by PhpStorm.
 * User: alxy
 * Date: 17.03.2015
 * Time: 02:51
 */

Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');