<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^/content/(reviews|articles|surveys)/([0-9]+)/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/content/reviews/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/blog/authors/([\\.\\-0-9a-zA-Z]+)(\\/)?(.*)?#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/authors/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/catalog/(.+)/(.+)(-comments)(/?)#',
    'RULE' => 'SECTION_ID=$1&ELEMENT_ID=$2',
    'ID' => 'bitrix:catalog.element',
    'PATH' => '/catalog/comments.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/catalog/(.+)/(.+)(-reviews)(/?)#',
    'RULE' => 'SECTION_ID=$1&ELEMENT_ID=$2',
    'ID' => 'bitrix:catalog.element',
    'PATH' => '/catalog/reviews.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/catalog/(.+)/(.+)(-ebook)(/?)#',
    'RULE' => 'SECTION_ID=$1&ELEMENT_ID=$2',
    'ID' => 'bitrix:catalog.element',
    'PATH' => '/catalog/ebook.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/tags/([0-9a-zA-Z_\\-]+)(/?)#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/tags/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/sitemap/([0-9a-zA-Z_]+)/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/sitemap/add.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/good-arithmetics-news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/good-arithmetics-news/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/testpersonal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/testpersonal/order/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/blog/authors/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/authors/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/testcatalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/testcatalog/index.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/catalog(/?)#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/teststore/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/teststore/index.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/series(/?)#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/series/index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/events(/?)#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/events/index.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/testnews/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/testnews/index.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/news(/?)#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  24 => 
  array (
    'CONDITION' => '#^/authors/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/authors/index.php',
    'SORT' => 100,
  ),
  25 => 
  array (
    'CONDITION' => '#^/store/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/store/index.php',
    'SORT' => 100,
  ),
  33 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  34 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 100,
  ),
);