<?php
namespace App\Workflow\Forms\Cart;

use Lavender\Support\Workflow;

class ItemUpdate extends Workflow
{

    public function __construct($params)
    {
        $this->options['action'] = url('cart/item/update');

        $this->addField('item_id', [
            'type' => 'hidden',
            'value' => isset($params->item) ? $params->item->id : -1,
            'validate' => ['required'],
        ]);

        $this->addField('qty', [
            'type' => 'text',
            'value' => isset($params->item) ? $params->item->qty : 1,
            'validate' => ['required'],
            'options' => ['class' => 'small-input'],
        ]);

        $this->addField('submit', [
            'type' => 'button',
            'value' => 'Edit',
            'options' => ['type' => 'submit']
        ]);
    }

}