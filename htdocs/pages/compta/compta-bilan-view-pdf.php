<?php 

define('FPDF_FONTPATH','include/font/');
require('include/fpdf.php');
require_once "include/config.inc.php";

if (isset($_GET['idperiode'])) $idperiode=verif_GetPost($_GET['idperiode']);

$idevenement=verif_GetPost($_GET['idevenement']);;

$rep=recup_periode($idperiode);
$periode_debut=$rep[0];
$periode_fin=$rep[1];

class PDF extends FPDF
{


function Header()       //En-t�te
{
    $this->Ln(1);              //Saut de ligne
}

//Pied de page
function Footer()
{
//    $this->SetY(-15);               //Positionnement � 1,5 cm du bas
//    $this->SetFont('Arial','I',8);  //Police Arial italique 8
//    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');      //Num�ro de page

}


function tableau($position,$header,$data)
{
	if ($position==1) $position=0; else $position=150;
	$y=30;
	
	//Couleurs, �paisseur du trait et police grasse
    $this->SetFillColor(128,128,128);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(250,250,250);
    $this->SetLineWidth(.2);
    $this->SetFont('Times','B',10);
    //En-t�te
//    $w=array(40,35,45,40);
  	$w=array(30,85,20);
    
  //  Categorie","Description","Montant
    //for($i=0;$i<count($header);$i++)
    //$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->SETXY($position,$y); 	
	$y +=5;
	$this->Cell($w[0],6,'Categorie','LR',0,'C');
    $this->Cell($w[1],6,'Description','LR',0,'C');
    $this->Cell($w[2],6,'Montant','LR',0,'C');
//	$this->Cell($w[0],6,'Categorie','LR',0,'C',$fill);
//    $this->Cell($w[1],6,'Description','LR',0,'C',$fill);
//    $this->Cell($w[2],6,'Montant','LR',0,'C',$fill);
       
    $this->Ln();
    
    //Restauration des couleurs et de la police
    $this->SetFillColor(224,224,224);
    $this->SetTextColor(0);
 //   $this->SetFont(8);
	$this->SetFont('Times','',10);
    //Donn�es
    $fill=false;

    foreach($data as $row)
    {
	$this->SETXY($position,$y);
    	$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);

        $this->Cell($w[1],6,substr($row[1],0,54),'LR',0,'L',$fill);
 //       $this->SETXY($position,$y);
        $this->Cell($w[2],6,number_format($row[2],2,',', ' '),'LR',0,'R',$fill);
//        $this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R',$fill);
        //$this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R',$fill);
//$montant=number_format($row->montant_theo, 2, ',', ' ');

        
        $this->Ln();
        $fill=!$fill;
		$y +=5;
    }
    $this->Cell(array_sum($w),0,'','T');
}



}


//-------------------------------------------------


//$start=verif_GetPost($_GET['start']);;
//if(!$start)
//    $start=0;
//else 
//	$start = $start;

/*$sql="select a.*,b.journal,c.operation,d.evenement,e.reglement 
	 FROM compta_ecriture a,compta_journal b,compta_operation c,compta_evenement d,compta_reglement e 
	 WHERE a.idjournal=b.id 
	 	AND a.idoperation=c.id 
	 	AND a.idmode_regl=e.id
	 	AND a.idevenement=d.id
	 	$filtre
	 	$order $ordre
	 ";
*/


//Instanciation de la classe d�riv�e
$pdf=new PDF('L','mm','A4');
//$pdf=new PDF();
$pdf->AliasNbPages();


$pdf->AddPage();

$pdf->SetFont('Times','B',18);
$pdf->Cell(0,5,recup_evenement($idevenement),0,0,'C');

//$data=view ($cnx,1);
//$i =  1=depense 2=recette	

if ($idevenement) $filtre_idevenement=" AND idevenement='$idevenement' "; else $filtre_idevenement=" ";
/*
$sql="SELECT * 
	   FROM compta 
	   WHERE idoperation='1' $filtre_idevenement 
	         AND date_ecriture>='$periode_debut' AND date_ecriture<='$periode_fin' 
	  ORDER BY date_ecriture,idevenement,idcategorie";
*/
$sql="SELECT compta.*,compta_categorie.id,compta_categorie.categorie   
	FROM compta, compta_categorie  
	WHERE compta.idoperation='1' AND compta.idevenement=$idevenement 
	         AND compta.date_ecriture>='$periode_debut' AND compta.date_ecriture<='$periode_fin' 
		  AND compta.idcategorie = compta_categorie.id     
	ORDER BY compta.date_ecriture,compta.idevenement,compta.idcategorie";

$qid=$cnx->prepare($sql);
$qid->execute();
      
$header[]= array ("Categorie","Description","Montant");

while( $row=$qid->fetch(PDO::FETCH_OBJ) ) 
{
   
$categorie=$row->categorie;    
$description=$row->description;  
$montant=$row->montant;
$data[]= array ($categorie ,$description,$montant);
$depense+=$montant;
}

$data[]=array('','Total D�penses',$depense);	

$pdf->Ln(10);  
$pdf->tableau(1,$header,$data);

//------------------------------------------------------

$dataRecette[]="";
$header[]="";

if ($idevenement) $filtre_idevenement=" AND idevenement=$idevenement "; else $filtre_idevenement=" ";
/*
$sql="SELECT * 
	   FROM compta 
	   WHERE idoperation='2' $filtre_idevenement
	         AND date_ecriture>='$periode_debut' AND date_ecriture<='$periode_fin' 
	  ORDER BY date_ecriture,idevenement,idcategorie";
*/
$sql="SELECT compta.*,compta_categorie.id,compta_categorie.categorie   
	FROM compta, compta_categorie  
	WHERE compta.idoperation='2' AND compta.idevenement=$idevenement 
	         AND compta.date_ecriture>='$periode_debut' AND compta.date_ecriture<='$periode_fin' 
		  AND compta.idcategorie = compta_categorie.id     
	ORDER BY compta.date_ecriture,compta.idevenement,compta.idcategorie";

$qid=$cnx->prepare($sql);
$qid->execute();
         
$header[]= array ('Categorie','Description','Montant');

while( $row=$qid->fetch(PDO::FETCH_OBJ) ) 
{
$categorie=$row->categorie;   
$description=$row->description;  
$montant=$row->montant;
$dataRecette[]= array ($categorie ,$description,$montant);
$recette+=$montant;
}
$dataRecette[]=array('','Total Recettes',$recette);


//$data=view ($cnx,2);
$pdf->Ln(10);  
$pdf->tableau(2,$header,$dataRecette);

$total=$recette-$depense;
$pdf->SetFont('Times','B',12);
$pdf->SETXY(0,180);
$pdf->Cell(0,5,"B�n�fices : ".number_format($total, 2, ',', ' '),0,0,'C');

$qid->closeCursor();
$cnx = null;

//$pdf->Output("c:\confirmation".$numero.".pdf");
$pdf->Output();

?>
