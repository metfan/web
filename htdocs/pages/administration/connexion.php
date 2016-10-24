<?php

// Impossible to access the file itself
if (!defined('PAGE_LOADED_USING_INDEX')) {
    trigger_error("Direct access forbidden.", E_USER_ERROR);
    exit;
}

// On supprime ce qui a déjà été écrit dans le buffer de sortie
// car on va afficher une page "indépendente"
ob_clean();

// On affiche la page de connexion
$statut = !empty($_GET['statut']) ? $_GET['statut'] : false;
$page_demandee = isset($_GET['page_demandee']) ? $_GET['page_demandee'] : null;

switch ($statut) {
    case AFUP_CONNEXION_ERROR_LOGIN:
        $message = 'Identifiants invalides';
        break;
    case AFUP_CONNEXION_ERROR_COTISATION:
        $message = 'Votre cotisation n\'est pas à jour';
        break;
    case AFUP_CONNEXION_ERROR:
        $message = 'Un problème est survenu sur votre compte, merci de prendre contact avec contact@afup.org';
        break;
    default:
        $message = '';
}

$smarty->assign('message', $message);
$smarty->assign('page_demandee', $page_demandee);
$smarty->display('connexion.html');

// On s'arrête là pour ne pas afficher le pied de page
exit;
?>