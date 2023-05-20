<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/class/base.php";

RegisterPlugin("SearchPlus", "ActivePlugin_SearchPlus");

function ActivePlugin_SearchPlus()
{
  Add_Filter_Plugin('Filter_Plugin_Zbp_PreLoad', 'SearchPlus_RegRoute');
  Add_Filter_Plugin('Filter_Plugin_PostArticle_Core', 'SearchPlus_PostArticle');
}

// 接口函数 - 发布文章
function SearchPlus_PostArticle(&$article)
{
  SearchPlus_IndexUpdate($article);
}

function SearchPlus_RegRoute()
{
  global $zbp;
  $route = array(
    'posttype' => 0,
    'type' => 'rewrite',
    'name' => 'post_article_search',
    'call' => 'ViewSearch',
    'urlrule' => '{%host%}search/{%q%}/{%page%}/',
    'args' => array(
      'q' => '[^\\/_]+',
      'page',
    ),
    'only_match_page' => false,
  );
  $zbp->RegRoute($route);
}

function InstallPlugin_SearchPlus()
{
  global $zbp;
  if (!$zbp->HasConfig('SearchPlus')) {
    $zbp->Config('SearchPlus')->version = 1;
    $zbp->Config('SearchPlus')->IndexPre= "zbp_";
    $zbp->SaveConfig('SearchPlus');
  }
}

function UninstallPlugin_SearchPlus()
{
}
