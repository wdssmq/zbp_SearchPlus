<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
  $zbp->ShowError(6);
  die();
}
if (!$zbp->CheckPlugin('SearchPlus')) {
  $zbp->ShowError(48);
  die();
}

$act = GetVars('act', 'GET');
$suc = GetVars('suc', 'GET');
if ($act == 'save') {
  CheckIsRefererValid();
  foreach ($_POST as $key => $val) {
    if (substr($key, 0, 5) == 'read_') {
      continue;
    }
    $zbp->Config('SearchPlus')->$key = trim($val);
  }
  $zbp->SaveConfig('SearchPlus');
  $zbp->BuildTemplate();
  $zbp->SetHint('good');
  Redirect('./main.php' . ($suc == null ? '' : "?act={$suc}"));
}

InstallPlugin_SearchPlus();

$blogtitle = '「水水」搜索增强';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle; ?></div>
  <div class="SubMenu">
  </div>
  <div id="divMain2">
    <form action="<?php echo BuildSafeURL("main.php?act=save"); ?>" method="post">
      <table width="100%" class="tableBorder">
        <tr>
          <th width="15%">项目</th>
          <th>内容</th>
          <th width="40%">说明</th>
        </tr>
        <!-- <tr>
          <td>Index 前缀</td>
          <td><?php zbpform::text("IndexPre", $zbp->Config("SearchPlus")->IndexPre, "90%"); ?></td>
          <td></td>
        </tr> -->
        <tr>
          <td>APP ID</td>
          <td><?php zbpform::text("AppID", $zbp->Config("SearchPlus")->AppID, "90%"); ?></td>
          <td></td>
        </tr>
        <tr>
          <td>API Key（仅搜索）</td>
          <td><?php zbpform::text("SearchOnlyKey", $zbp->Config("SearchPlus")->SearchOnlyKey, "90%"); ?></td>
          <td></td>
        </tr>
        <tr>
          <td>API Key（管理）</td>
          <td><?php zbpform::password("AdminKey", $zbp->Config("SearchPlus")->AdminKey, "90%"); ?></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2"><input type="submit" value="提交" /><small><a title="刷新" href="javascript:;" onclick="location.reload();" style="font-size: 16px;display: inline-block;margin-left: 5px;">刷新</a></small></td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
