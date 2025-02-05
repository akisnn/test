<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Форма обратной связи');
?>
<?php
$APPLICATION->IncludeComponent(
    "test:feedback.form",
    ".default",
    Array(
        "IBLOCK_TYPE" => "test",
        "IBLOCK_CODE" => "fos"
    )
);?>
<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>