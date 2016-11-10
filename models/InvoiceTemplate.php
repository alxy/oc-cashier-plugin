<?php namespace Alxy\Cashier\Models;

use App;
use File;
use Model;
use October\Rain\Syntax\Parser;

/**
 * InvoiceTemplate Model
 */
class InvoiceTemplate extends Model
{
    use \October\Rain\Syntax\SyntaxModelTrait;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'alxy_cashier_invoice_templates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array List of attribute names which are json encoded and decoded from the database.
     */
    protected $jsonable = ['syntax_data', 'syntax_fields'];

    public $timestamps = false;

    public function getContentCssAttribute($content)
    {
        if (!$this->exists || !strlen($content))
            return File::get(__DIR__ . '/invoicetemplate/default_content.css');
        return $content;
    }

    public function getContentHtmlAttribute($content)
    {
        if (!$this->exists || !strlen($content))
            return File::get(__DIR__ . '/invoicetemplate/default_content.htm');
        return $content;
    }

    public function beforeSave()
    {
        $this->makeSyntaxFields($this->content_html);
    }

    public function renderInvoice($invoice)
    {
        $parser = $this->getSyntaxParser($this->content_html);
        $invoiceData = $this->getSyntaxData();
        $invoiceTemplate = $parser->render($invoiceData);

        $twigData = [
            'invoice' => $invoice,
            'css' => $this->content_css
        ];
        $twigTemplate = Twig::parse($invoiceTemplate, $twigData);

        return $twigTemplate;
    }
}
