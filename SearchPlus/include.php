<?php
RegisterPlugin("SearchPlus", "ActivePlugin_SearchPlus");

function ActivePlugin_SearchPlus()
{
  Add_Filter_Plugin('Filter_Plugin_Zbp_PreLoad', 'SearchPlus_RegRoute');
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
}

function UninstallPlugin_SearchPlus()
{
}
