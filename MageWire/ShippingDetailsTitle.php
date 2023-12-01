<?php declare(strict_types=1);

namespace YireoTraining\ExampleHyvaCheckoutInStorePickup\MageWire;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magewirephp\Magewire\Component;

class ShippingDetailsTitle extends Component
{
    protected $listeners = [
        'shipping_method_selected' => 'refresh'
    ];

    public function __construct(
        private CheckoutSession $checkoutSession
    ) {
    }

    public function boot()
    {
        $quote = $this->checkoutSession->getQuote();
        if ($quote->getShippingAddress()->getShippingMethod() === 'custom_pickup_custom_pickup') {
            $this->getParent()?->setTitle(__('In Store Pickup'));
            return;
        }

        $this->getParent()?->setTitle(__('Shipping Address'));
    }
}
