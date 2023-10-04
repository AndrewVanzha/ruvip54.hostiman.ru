<?php
$arUrlRewrite=array (
  8 => 
  array (
    'CONDITION' => '#^/katalog/([^/]+?)/filter/(.+?)/apply/\\??(.*)#',
    'RULE' => 'SECTION_CODE=$1&SMART_FILTER_PATH=$2&$3',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/katalog/sektion.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/video([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/katalog/([^/]+?)/([^/]+?)/\\??(.*)#',
    'RULE' => 'SECTION_CODE=$1&ELEMENT_CODE=$2&$3',
    'ID' => 'bitrix:catalog.element',
    'PATH' => '/katalog/element.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/katalog/([^/]+?)/\\??(.*)#',
    'RULE' => 'SECTION_CODE=$1&$2',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/katalog/sektion.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/katalog/\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.top',
    'PATH' => '/katalog/index.php',
    'SORT' => 100,
  ),
  23 => 
  array (
    'CONDITION' => '#^/novyyblog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/novyyblog/index.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/tekhnika/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/tekhnika/index.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/dop1/infoblok/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/dop1/infoblok/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/delo/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/delo/index.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/avto/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/avto/index.php',
    'SORT' => 100,
  ),
  24 => 
  array (
    'CONDITION' => '#^/moda/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/moda/index.php',
    'SORT' => 100,
  ),
  25 => 
  array (
    'CONDITION' => '#^/vid/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/vid/index.php',
    'SORT' => 100,
  ),
);
