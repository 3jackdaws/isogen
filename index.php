<?php
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/Page.php');

$page = new \Page\MainPage();
$page->createPage();
?>
<script>
    console.log(<?=$_SERVER['HTTP_IF_MODIFIED_SINCE']?>);
</script>
