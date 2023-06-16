<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_after.php");

use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Item;

$title = $_POST['title'];
$username = $_POST['username'];
$sum = $_POST['sum'];
$parentId = $_POST['parentId'];

function createSmartProcessElement($title, $username, $sum)
{
    // Создание элемента смарт-процесса
    $typeid = 160; // Замените на соответствующий идентификатор смарт-процесса типа int
    $factory = Container::getInstance()->getFactory($typeid);

    if (!$factory) {
        throw new \Exception('Фабрика не найдена для указанного типа');
    }

    $item = $factory->createItem([
        Item::FIELD_NAME_STAGE_ID => 'DT' . $typeid . '_4:NEW',
    ]);

    $fields = [
        'UF_CRM_5_1685541299' => $title,
        'UF_CRM_5_1685544615' => $username,
        'UF_CRM_5_1685544814' => $sum,
        'FIELDS[TITLE]' => $title

    ];

    $item->setFromCompatibleData($fields);


    try {
        $result = $item->save();
        $elementId = $result->getId();

        // Возвращение созданного элемента
        return $elementId;
    } catch (\Exception $e) {
        // Обработка ошибки при сохранении элемента
        throw new \Exception('Ошибка при создании элемента: ' . $e->getMessage());
    }
}

try {
    $elementId = createSmartProcessElement($title, $username, $sum);
    echo json_encode(['success' => true, 'elementId' => $elementId]);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}