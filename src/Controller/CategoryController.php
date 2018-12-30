<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonces;
use App\Entity\Catalogue;
use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category")
     */
    public function index()
    {  
    	$annonces = $this->getDoctrine()
        ->getRepository(Annonces::class)
        ->findAll();

       $req1=$annonces;
       
 $conn = $this->getDoctrine()->getManager()->getConnection();
        $sql = 'SELECT annonces.*, catalogue.urlimg,catalogue.annonce_id  FROM annonces,catalogue where annonces.id=catalogue.annonce_id 
        group by catalogue.annonce_id ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(); 
       
         $req2=$stmt;
       /* $req2=DB::table('annonces')
        ->rightjoin('catalog', 'annonces.id', '=', 'catalog.annonce_id')
        ->select('annonces.*','catalog.urlimg','catalog.annonce_id' )
        ->groupBy('catalog.annonce_id')

        ->get();*/

 $req= $this->getDoctrine()
        ->getRepository(Categories::class)
        ->findAll();
      
        
        return $this->render('category/index.html.twig', array(
           'req' => $req,
             'req1' => $req1,
              'req2' => $req2,
        ));
    }
     /**
     * @Route("deleteCat", name="Deletcat")
     */

    public function destroy(Request $request)
    {

        $id = $request->request->get('categories');
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $req='delete from categories where id='. $id;
        
 $req1='delete from annonces where category_id='.$id;
 $req2='delete from subcategory where category_id='.$id;
        $resreq=$conn->prepare($req);
          $resreq1=$conn->prepare($req1);
          $resreq2=$conn->prepare($req2);
       
        $resreq1->execute();
        $resreq2->execute();
        $resreq->execute();

        
        
        return $this->redirectToRoute('adminCategories');
    }

 /**
     * @Route("CreatCat", name="CreatCat")
     */

    public function Creat(Request $request)
    {

        $type = $request->request->get('add');
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $req='insert into  categories values(null,"'.$type.'","default")';
        
 
        $resreq=$conn->prepare($req);
          
       
       
        $resreq->execute();

        
        
        return $this->redirectToRoute('adminCategories');
    }

    }

