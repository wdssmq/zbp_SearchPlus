<?php
// 所有函数以 SearchPlus_ 开头

use \AlgoliaSearch\Client;

// 封装一个函数，用以初始化 Algolia 的客户端
function SearchPlus_InitAlgoliaClient($indexName, $returnIndex = true)
{
  global $zbp;
  $IndexPre = $zbp->Config('SearchPlus')->IndexPre;
  $AppID = $zbp->Config('SearchPlus')->AppID;
  $AdminKey = $zbp->Config('SearchPlus')->AdminKey;
  $client = new Client(
    $AppID,
    $AdminKey
  );
  // var_dump($client->listIndexes());
  // var_dump($client->getLogs());
  if ($returnIndex) {
    $index = $client->initIndex($IndexPre . $indexName);
    return $index;
  }
  return $client;
}

// 更新索引
function SearchPlus_IndexUpdate($articleOrID, $type = "def")
{
  global $zbp;
  $index = SearchPlus_InitAlgoliaClient($type);
  // 如果 articleOrID 是数字，那么就是文章 ID
  if (is_numeric($articleOrID)) {
    $id = $articleOrID;
    $article = $zbp->GetPostByID($id);
  } else {
    $article = $articleOrID;
  }
  // 如果文章不是发布状态，那么就不更新索引
  if ($article->Status != 0) {
    return;
  }
  $res = $index->saveObject(array(
    'objectID' => $article->ID,
    'title' => $article->Title,
    'intro' => $article->Intro,
    'content' => $article->Content,
    'url' => $article->Url,
    'tags' => $article->TagsName,
    'category' => $article->Category->Name,
    'author' => $article->Author->Name,
    'type' => $article->TypeName,
    'status' => $article->StatusName,
    // 'meta' => $article->Metas,
  ));
}

// 搜索
function SearchPlus_Search($q, $type = "def")
{
  $index = SearchPlus_InitAlgoliaClient($type);
  $res = $index->search($q);
  return $res;
}
