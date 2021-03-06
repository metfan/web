<?php
use Afup\Site\Rendez_Vous;
use Afup\Site\Utils\Logs;

require_once dirname(__FILE__) .'/../../../sources/Afup/Bootstrap/Http.php';



Logs::initialiser($bdd, 0);

$rendezvous = new Rendez_Vous($bdd);
$lister_rendezvous = $rendezvous->obtenirListe();

if (isset($lister_rendezvous) and is_array($lister_rendezvous)) {
	foreach ($lister_rendezvous as &$rendezvous) {
		$rendezvous['est_futur'] = ($rendezvous['debut'] <= time()) ? FALSE : TRUE;
		$rendezvous['date'] = date("d/m/Y", $rendezvous['debut']);
		$rendezvous['debut'] = date("H\hi", $rendezvous['debut']);
		$rendezvous['fin'] = date("H\hi", $rendezvous['fin']);
	}
	$smarty->assign('listerendezvous', $lister_rendezvous);
	$smarty->display('archives-rendezvous.html');

} else {
	$smarty->display('pas-de-rendezvous.html');
}