<?php namespace Alxy\Cashier\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('alxy_cashier_invoice_templates', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('content_html')->nullable();
            $table->text('content_css')->nullable();
            $table->text('syntax_data')->nullable();
            $table->text('syntax_fields')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alxy_cashier_invoice_templates');
    }
}