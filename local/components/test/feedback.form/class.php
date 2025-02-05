<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use \Bitrix\Iblock\IblockTable;

class FeedbackForm extends CBitrixComponent implements \Bitrix\Main\Engine\Contract\Controllerable, \Bitrix\Main\Errorable
{
    protected $errorCollection;

    public function onPrepareComponentParams($arParams)
    {
        $this->errorCollection = new ErrorCollection();
        return $arParams;
    }

    public function executeComponent()
    {
        \Bitrix\Main\Loader::includeModule('iblock');

        $this->arResult=[];

        $iblockId = \Bitrix\Iblock\IblockTable::getList(['filter'=>['CODE'=>$this->arParams['IBLOCK_CODE']]])->Fetch()["ID"];

        $elements = \Bitrix\Iblock\Elements\ElementFosTable::getList([
            "select" => [
                "ID",
                "NICKNAME_VALUE" => "NICKNAME.VALUE",
                "CONS_VALUE" => "CONS.VALUE",
                "PROS_VALUE" => "PROS.VALUE",
                "REVIEW_VALUE" => "REVIEW.VALUE"
            ],
            "filter"=>[
                'IBLOCK_ID' => $iblockId,
                'ACTIVE' => 'Y' // модерация по свойству ACTIVE
            ],
            "order" => [
                "ID" => "DESC",
            ],
            "limit" => 10
        ])->fetchAll();


        foreach ($elements as $key => $element) {
            $review = unserialize($element['REVIEW_VALUE']);
            $element['REVIEW_VALUE'] = $review['TEXT'];
            $this->arResult['REVIEWS'][] = $element;
        };

        $this->includeComponentTemplate();
    }

    public function saveAction()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $data = $request->getPostList()->getValues();

        \Bitrix\Main\Loader::includeModule('iblock');

        $iblockId = (int)\Bitrix\Iblock\IblockTable::getList(['filter'=>['CODE'=>'fos']])->Fetch()["ID"];

        $el = new CIBlockElement;
        $PROPS = [
            'NICKNAME' => $data['nickname'],
            'PROS' => $data['pros'],
            'CONS' => $data['cons'],
            'REVIEW' => $data['review']
        ];
        if($res = $el->Add([
            'IBLOCK_ID' => $iblockId,
            'NAME' => 'tst',
            'ACTIVE' => 'N',
            'PROPERTY_VALUES' => $PROPS]
        )){
            //echo 'New ID: '.$PRODUCT_ID;
        }else{
            //echo 'Error: '.$el->LAST_ERROR;
        }
    }

    public function configureActions()
    {
        return [
            'save' => [
                'prefilters' => [
                ]
            ],
        ];
    }

    public function getErrors()
    {
        return $this->errorCollection->toArray();
    }

    public function getErrorByCode($code)
    {
        return $this->errorCollection->getErrorByCode($code);
    }

}



