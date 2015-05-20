<?php
// Данный скрипт собирает ВСЕ элементы инфоблока с ID=1
// и присваивает свойству с кодом "YOUR_PROPERTY_CODE" значения от 000001 подряд. (сортировка элементов по возрастаню их ID)
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
set_time_limit(86400);

CModule::IncludeModule('iblock'); // Проверяем наличие подключённого модуля Инфоблоки

$CIBlockElement = new CIBlockElement();

$arSort = array( //Массив для сортировки
    'ID' => 'ASC'
);

$arFilter = array( // Массив для фильтрации
    'IBLOCK_ID' => 1
);

$arSelectFields=Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_YOUR_PROPERTY_CODE"); // выбираем поля для вывода. IBLOCK_ID и ID ОБЯЗАТЕЛЬНЫ

$rsElements = $CIBlockElement->GetList($arSort, $arFilter, $arSelectFields); // https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockelement/getlist.php
$i=0; // Счётчик элементов
function zero($digit, $width) {// Функция для вывода числа с ведущими нулями
    while(strlen($digit) < $width)
        $digit = '0' . $digit;
    return $digit;
}
while($tmpElement = $rsElements->Fetch()) //обрабатываем полученные элементы
{   $i++;
    $arElement["PROPERTY_YOUR_PROPERTY_CODE"]=zero($i, 6);

    echo '<span style="color:green;">'.'Обновление элемента '.$tmpElement['NAME'].' (ID='.$tmpElement['ID'].')</span><br>';
    $updated = $CIBlockElement->Update($tmpElement['ID'], $arElement);
    if($updated){
        echo '<span style="color:green;">'.$tmpElement['NAME'].'(ID='.$tmpElement['ID'].') элемент обновлен</span><br>';
    }else{
        echo '<span style="color:red;">'.$tmpElement['NAME'].'(ID='.$tmpElement['ID'].') ошибка во время обновления элемента</span><br>';
    }
}
echo '<span style="color:green;">'.'Было обновлено '.$i.' элементов</span><br>';
echo '<div style="font-weight:bold; font-size:2em; color:green;">Все операции выполнены</div>';?>