<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonces;
use App\Entity\Catalogue;
class DetailsController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="details")
     */
    public function index($id)
    {
    	$conn = $this->getDoctrine()->getManager()->getConnection();

       /* $repository = $this->getDoctrine()->getRepository(Catalogue::class);
        $req1 = $repository->findBy(
    ['annonce_id' => $id]
    
);*/
        $sqlreq1 ='select * from catalogue where annonce_id='.$id;
        $req1 = $conn->prepare($sqlreq1);
        $req1->execute();
        $sqlreq22 ='select * from catalogue where annonce_id='.$id;
        $req22 = $conn->prepare($sqlreq22);
        $req22->execute();
        //$req1->fetchAll();




 $details= $this->getDoctrine()
        ->getRepository(Annonces::class)
        ->find($id);
        
    	
        $sqluser='select * from user,annonces where user.id=annonces.user_id and annonces.id='.$id;
         $user=$conn->prepare($sqluser);
         $user->execute();

        
        return $this->render('details/index.html.twig', array(
           'user' => $user,
             'req1' => $req1,
              'details' => $details,
              'req22' => $req22,
        ));
    }
}
