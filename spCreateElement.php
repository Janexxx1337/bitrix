<?php

use Bitrix\Crm\Service;
use Bitrix\Crm\Service\Container;
use Bitrix\Main\Loader;
Loader::includeModule('crm');
$typeid = '135';//Идентификатор смарт-процесса
$userId = 3;  ///Айди профиля
$factory = Service\Container::getInstance()->getFactory($typeid);

if ($factory && $factory->isStagesSupported()){
$stages = $factory->getStages()->getAll();
foreach( $stages as $stage){
$arStages = $stage->getStatusId();
}} /// Получаем стадии сущности из фабрики

$data = [
'TITLE' => 'nametest',
'ASSIGNED_BY_ID'=>$userId,

];
$item = $factory ->createItem($data);
$item->save();
echo "<PRE>";
print_r($item->save());
echo "</PRE>";