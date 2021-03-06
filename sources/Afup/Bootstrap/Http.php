<?php
/**
 * Fichier (bootstrap) du contexte HTTP (page web)
 * 
 * Ce fichier doit contenir l'ensemble des directives d'initialisation
 * nécessaire au chargement de toute l'application pour une exécution
 * d'une page web (script php à destination du web)
 * 
 * Ce fichier est systématiquement à inclure en haut de chaque
 * page.
 * 
 * @author    Perrick Penet   <perrick@noparking.fr>
 * @author    Olivier Hoareau <olivier@phppro.fr>
 * @copyright 2010 Association Française des Utilisateurs de PHP
 * 
 * @category AFUP
 * @package  AFUP
 * @group    Bootstraps
 */

// chargement des paramétrages génériques / multi-contextuels de l'application

require_once dirname(__FILE__) . '/_Common.php';

// initialisation de la session / requête
if (ob_get_level() === 0) {
    ob_start();
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// mise à jour des paramètrage PHP en fonction de la configuration

ini_set('error_reporting', $GLOBALS['AFUP_CONF']->obtenir('divers|niveau_erreur'));
ini_set('display_errors',  $GLOBALS['AFUP_CONF']->obtenir('divers|afficher_erreurs'));
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__).'/../../../dependencies/PEAR/');

header('Content-type: text/html; charset=UTF-8');

// choix du 'sous-site' en fonction de l'url

$serveur   = '';
$url = $_SERVER['REQUEST_URI'];
if (strrpos($url, '?') !== false) {
	$position = strrpos($url, '?');
	$url      = substr($url, 0, $position);
}
$position  = strrpos($url, '/');
$url       = substr($_SERVER['REQUEST_URI'], 0, $position);
$parties   = explode('/', $url);
$sous_site = array_pop($parties);
if (empty($sous_site) and strpos($_SERVER['HTTP_HOST'], "planete") !== false) {
	$sous_site = "planete";
}

// initialisation de Smarty, le moteur de template (html)

$smarty = new Smarty;
$smarty->template_dir  = array(
    AFUP_CHEMIN_RACINE . 'templates/' . $sous_site . '/',
    AFUP_CHEMIN_RACINE . 'templates/commun/',
);
$smarty->compile_dir   = AFUP_CHEMIN_RACINE . 'cache/templates';
$smarty->compile_id    = $sous_site;
$smarty->use_sub_dirs  = true;
$smarty->compile_check = true;
$smarty->php_handling  = SMARTY_PHP_ALLOW;

$smarty->assign('url_base',          'http://' . $_SERVER['HTTP_HOST'] . '/');
$smarty->assign('chemin_template',   $serveur.$GLOBALS['AFUP_CONF']->obtenir('web|path').'templates/' . $sous_site . '/');
$smarty->assign('chemin_javascript', $serveur.$GLOBALS['AFUP_CONF']->obtenir('web|path').'javascript/');

$GLOBALS['AFUP_DB']->executer("SET NAMES 'utf8'");
require_once(dirname(__FILE__) . '/commonStart.php');
