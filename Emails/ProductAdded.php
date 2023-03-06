<?php

namespace Modules\Product\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\HtmlString;
use Modules\Product\Models\Product;

class ProductAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text(new HtmlString('Product Added'))
            ->subject('New Product Added')
            ->with([
                'product_name' => $this->product->name,
                'product_price' => $this->product->price,
                'created_by' => $this->product->creator->name,
            ]);
    }

}
