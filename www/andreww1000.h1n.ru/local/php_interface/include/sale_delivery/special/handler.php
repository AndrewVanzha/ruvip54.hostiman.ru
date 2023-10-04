<?php
namespace Sale\Handlers\Delivery;

use Bitrix\Sale\Delivery\CalculationResult;
use Bitrix\Sale\Delivery\Services\Base;

class SpecialHandler extends Base
{
    public static function getClassTitle()
    {
        return "Специальная доставка";
		//return $MESS["SALE_DLVR_HANDL_SMPL_TITLE"];
    }

    public static function getClassDescription()
    {
        return "Доставка, стоимость которой зависит от скидки на товар";
		//return $MESS["SALE_DLVR_HANDL_SMPL_DESCRIPTION"];
    }

    protected function calculateConcrete(\Bitrix\Sale\Shipment $shipment)
    {
        $result = new CalculationResult();

        $shipmentBasket = array();
        $deliverySum = 0;
        foreach($shipment->getShipmentItemCollection() as $item) {
            $basketItem = $item->getBasketItem();
            if (!$basketItem->canBuy() || $basketItem->isDelay()) continue;
            $arItem = array(
                'PRODUCT_ID' => $basketItem->getProductId(),
                'NAME' => $basketItem->getField('NAME'),
                'PRICE' => $basketItem->getPrice(),    // за единицу
                'FINAL_PRICE' => $basketItem->getFinalPrice(),  // сумма
                'QUANTITY' => $basketItem->getQuantity(),
                'BASE_PRICE' => $basketItem->getBasePrice(),
                'DISCOUNT_PRICE' => $basketItem->getDiscountPrice(),
            );
            $shipmentBasket[$arItem['PRODUCT_ID']] = $arItem;
            $deliverySum += $arItem['DISCOUNT_PRICE'] * $arItem['QUANTITY'];
        }

        $result->setDeliveryPrice(roundEx($deliverySum, 2));
        $result->setPeriodDescription('1 день');

        return $result;
    }

    protected function getConfigStructure()
    {
        return array(
            "MAIN" => array(
                "TITLE" => 'Настройка обработчика',
                "DESCRIPTION" => 'Настройка обработчика',"ITEMS" => array(
                    "PRICE" => array(
                        "TYPE" => "NUMBER",
                        "MIN" => 0,
                        "NAME" => 'Стоимость доставки за грамм'
                    )
                )
            )
        );
    }

    public function isCalculatePriceImmediately()
    {
        return true;
    }

    public static function whetherAdminExtraServicesShow()
    {
        return true;
    }
}

// https://www.infospice.ru/blog/bitrix_inside/bitriks-i-d7-tovary-v-otgruzke/
// https://dev.1c-bitrix.ru/api_d7/bitrix/sale/classes/shipment/index.php
