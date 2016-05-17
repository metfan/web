<?php
use Afup\Site\Corporate\Page;

require_once dirname(__FILE__) .'/../../../sources/Afup/Bootstrap/Http.php';

$page = new Page($bdd);

if (isset($_GET['page']) && $_GET['page'] == 'inscription') {
    header('Location: /pages/administration/index.php?page=inscription');
}

$page->definirRoute(isset($_GET['route']) ? $_GET['route'] : '');

$smarty->assign('community', $page->community());
$smarty->assign('header', $page->header());
$smarty->assign('content', $page->content());
$smarty->assign('social', $page->social());
$smarty->assign('footer', $page->footer());

$smarty->display('index.html');