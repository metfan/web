<?php


namespace Afup\Site\Forum;


class InscriptionType
{
    private $types = [
        'AFUP_FORUM_PREMIERE_JOURNEE' => AFUP_FORUM_PREMIERE_JOURNEE  ,
        'AFUP_FORUM_DEUXIEME_JOURNEE' => AFUP_FORUM_DEUXIEME_JOURNEE  ,
        'AFUP_FORUM_2_JOURNEES' => AFUP_FORUM_2_JOURNEES  ,
        'AFUP_FORUM_2_JOURNEES_AFUP' => AFUP_FORUM_2_JOURNEES_AFUP  ,
        'AFUP_FORUM_2_JOURNEES_ETUDIANT' => AFUP_FORUM_2_JOURNEES_ETUDIANT  ,
        'AFUP_FORUM_2_JOURNEES_PREVENTE' => AFUP_FORUM_2_JOURNEES_PREVENTE  ,
        'AFUP_FORUM_2_JOURNEES_AFUP_PREVENTE' => AFUP_FORUM_2_JOURNEES_AFUP_PREVENTE  ,
        'AFUP_FORUM_2_JOURNEES_ETUDIANT_PREVENTE' => AFUP_FORUM_2_JOURNEES_ETUDIANT_PREVENTE  ,
        'AFUP_FORUM_2_JOURNEES_COUPON' => AFUP_FORUM_2_JOURNEES_COUPON  ,
        'AFUP_FORUM_ORGANISATION' => AFUP_FORUM_ORGANISATION  ,
        'AFUP_FORUM_SPONSOR' => AFUP_FORUM_SPONSOR  ,
        'AFUP_FORUM_PRESSE' => AFUP_FORUM_PRESSE  ,
        'AFUP_FORUM_CONFERENCIER' => AFUP_FORUM_CONFERENCIER  ,
        'AFUP_FORUM_INVITATION' => AFUP_FORUM_INVITATION  ,
        'AFUP_FORUM_PROJET' => AFUP_FORUM_PROJET  ,
        'AFUP_FORUM_2_JOURNEES_SPONSOR' => AFUP_FORUM_2_JOURNEES_SPONSOR  ,
        'AFUP_FORUM_PROF' => AFUP_FORUM_PROF  ,
        'AFUP_FORUM_PREMIERE_JOURNEE_ETUDIANT_PREVENTE' => AFUP_FORUM_PREMIERE_JOURNEE_ETUDIANT_PREVENTE  ,
        'AFUP_FORUM_DEUXIEME_JOURNEE_ETUDIANT_PREVENTE' => AFUP_FORUM_DEUXIEME_JOURNEE_ETUDIANT_PREVENTE  ,
        'AFUP_FORUM_2_JOURNEES_PREVENTE_ADHESION' => AFUP_FORUM_2_JOURNEES_PREVENTE_ADHESION  ,
        'AFUP_FORUM_PREMIERE_JOURNEE_AFUP' => AFUP_FORUM_PREMIERE_JOURNEE_AFUP  ,
        'AFUP_FORUM_DEUXIEME_JOURNEE_AFUP' => AFUP_FORUM_DEUXIEME_JOURNEE_AFUP  ,
        'AFUP_FORUM_PREMIERE_JOURNEE_ETUDIANT' => AFUP_FORUM_PREMIERE_JOURNEE_ETUDIANT  ,
        'AFUP_FORUM_DEUXIEME_JOURNEE_ETUDIANT' => AFUP_FORUM_DEUXIEME_JOURNEE_ETUDIANT  ,
    ];

    /**
     * @param $id integer
     * @return string|null Type
     */
    public function getTypeNameById($id)
    {
        if (array_search($id, $this->types) === false) {
            return null;
        }
        return array_search($id, $this->types);
    }
}