<?php declare(strict_types=1);

namespace YireoTraining\ExampleHyvaCheckoutInStorePickup\Plugin;

use Hyva\Checkout\Magewire\Checkout\AddressView\ShippingDetails;
use Magento\Checkout\Model\Session as CheckoutSession;

class SwapShippingForm
{
    public function __construct(
        private CheckoutSession $checkoutSession
    ) {
    }

    /**
     * @param ShippingDetails $subject
     */
    public function afterBoot(ShippingDetails $subject)
    {
        $quote = $this->checkoutSession->getQuote();
        if ($quote->getShippingAddress()->getShippingMethod() === 'custom_pickup_custom_pickup') {
            $subject->switchTemplate('YireoTraining_ExampleHyvaCheckoutInStorePickup::form.phtml');
            return;
        }

        $subject->switchTemplate('Hyva_Checkout::checkout/address-view/shipping-details.phtml');
    }

    public function afterGetListeners(ShippingDetails $subject, array $listeners): array
    {
        $listeners['shipping_method_selected'] = 'refresh';
        return $listeners;
    }
}
