<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;

class ReservationRateForm extends CBitrixComponent
{
    protected function getResult()
    {
        $request = Application::getInstance()->getContext()->getRequest();

        $this->arResult['GET_ARR'] = [
            'type' => $request->getQuery('type'),
            'rate' => $request->getQuery('rate'),
            'amount' => $request->getQuery('amount'),
            'fio' => $request->getQuery('fio'),
            'phone' => $request->getQuery('phone'),
            'email' => $request->getQuery('email'),
            'currency' => $request->getQuery('currency'),
            'message' => $request->getQuery('message')
        ];
    }

    public function executeComponent()
    {
        try {
            $this->getResult();

            $this->includeComponentTemplate();
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}