<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SubCatController extends AbstractController
{
    /**
     * @Route("/sub/cat/{id}", name="sub_cat")
     */
    public function index($id)
{

$conn = $this->getDoctrine()->getManager()->getConnection();
        $sqlqq = 'SELECT annonces.*, catalogue.urlimg,catalogue.annonce_id  FROM annonces,catalogue where annonces.id=catalogue.annonce_id and annonces.category_id='.$id;
        $qq = $conn->prepare($sqlqq);
        $qq->execute();



$sqlreq='select * from subcategory where  category_id='.$id;


        $req=$conn->prepare($sqlreq);
        $req->execute();

       $req1= $this->getDoctrine()
        ->getRepository(Categories::class)
        ->find($id);

       // $req1=Categories::select('*')->where('id', $id)->get();
       /* $q=DB::table('annonces')
        ->select('*' )
        ->where('categories_id','=',$id)*/

        //->get();
       

        

     




        return $this->render('sub_cat/index.html.twig', array(
           'qq' => $qq,
             'req1' => $req1,
              'req' => $req,
        ));
    

    }

     /**
     * @Route("/sub/catshow/{id}/{idd}", name="sub_catshow")
     */

    public function show($id,$idd)
    {
$conn = $this->getDoctrine()->getManager()->getConnection();

        $sqlreq='select * from subcategory where  category_id='.$id;


        $req=$conn->prepare($sqlreq);
        $req->execute();


       
        

$req1= $this->getDoctrine()
        ->getRepository(Categories::class)
        ->find($id);
        
       



$sqlqq = 'SELECT annonces.*, catalogue.urlimg,catalogue.annonce_id  FROM annonces,catalogue where annonces.id=catalogue.annonce_id and annonces.sub_category_id='.$idd;
        $qq = $conn->prepare($sqlqq);
        $qq->execute();


        /*$qq=DB::table('annonces')
        ->rightjoin('catalog', 'annonces.id', '=', 'catalog.annonce_id')
        ->select('annonces.*','catalog.urlimg','catalog.annonce_id' )
        ->where('subcategory_id','=',$idd)
       ->groupBy('catalog.annonce_id')
        
        ->get();*/
       
       
        return $this->render('sub_cat/subcatshow.html.twig', array(
           'qq' => $qq,
             'req1' => $req1,
              'req' => $req,
        ));
    }
 /**
     * @Route("deleteSubCat", name="DeletSubCat")
     */

    public function destroy(Request $request)
    {

        $id = $request->request->get('subcategories');
        $conn = $this->getDoctrine()->getManager()->getConnection();
        
        
 $req1='delete from annonces where sub_category_id='.$id;
 $req2='delete from subcategory where id='.$id;
        $resreq1=$conn->prepare($req1);
          $resreq2=$conn->prepare($req2);
       
        $resreq1->execute();
        $resreq2->execute();
       

        
        
        return $this->redirectToRoute('adminSubCat');
    }

 /**
     * @Route("CreateSubCat", name="CreateSubCat")
     */

    public function Creat(Request $request)
    {

        $id = $request->request->get('categories');
        $type = $request->request->get('add');
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $req='insert into  subcategory values(null,"'.$type.'","'.$id.'")';
        
 
        $resreq=$conn->prepare($req);
          
       
       
        $resreq->execute();

        
        
        return $this->redirectToRoute('adminSubCat');
    }
}
