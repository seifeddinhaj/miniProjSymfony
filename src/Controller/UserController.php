<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Flex\Response;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response ;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Categories;
use App\Entity\Subcategory;
use App\Entity\User;
use App\Entity\Annonces;
use App\Entity\Catalogue;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use  Symfony\Component\HttpFoundation\File\UploadedFile;


class UserController extends AbstractController
{
    /**
     * @Route("/myads/{id}", name="myads")
     */
    public function index($id)

    {
    	$conn = $this->getDoctrine()->getManager()->getConnection();
$sqlreq2='SELECT annonces.*, catalogue.urlimg,catalogue.annonce_id  FROM annonces,catalogue where annonces.id=catalogue.annonce_id and annonces.user_id='.$id.' group by catalogue.annonce_id ';


        $req2=$conn->prepare($sqlreq2);
        $req2->execute();



    	



        return $this->render('user/myads.html.twig', [
            'req2' => $req2,
        ]);
    }


     /**
     * @Route("/addAds", name="AddAds")
     */
    public function creat()

    {
    	

 $conn = $this->getDoctrine()->getManager()->getConnection();



 $req= $this->getDoctrine()
        ->getRepository(Categories::class)
        ->findAll();
       

    	//$conn = $this->getDoctrine()->getManager()->getConnection();
$sql='SELECT id,type from subcategory where category_id=1';


        $subcat=$conn->prepare($sql);
        $subcat->execute(); 




        return $this->render('user/addAd.html.twig', [
            'req' => $req,
            'subcat'=>$subcat
        ]);
    }

    /**
     * @Route("myform/ajax/{id}", name="myformajax")
     */
    public function myformAjax($id)
    {
$conn = $this->getDoctrine()->getManager()->getConnection();
$sql='SELECT id,type from subcategory where category_id='.$id;


        $subcat=$conn->prepare($sql);
        $subcat->execute(); 
        $res=$subcat->fetchAll();


       
          $response = new JsonResponse();
          $response->setData($res);       
        return     ($response);
    }

     /**
     * @Route("CreatAn/store/{id}", name="addAnn")
     */
    public function store(Request $request,$id)
    {
        
       $annonce= new Annonces();
        $id_cat = $request->request->get('categories');
        $id_subcat = $request->request->get('subcategory');
        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $type = $request->request->get('type');
        $adresse = $request->request->get('location');
        $id_user = $id;
        $price = $request->request->get('price');

       $category= $this->getDoctrine()
        ->getRepository(Categories::class)
        ->find($id_cat);
        $subcategory= $this->getDoctrine()
        ->getRepository(Subcategory::class)
        ->find($id_subcat);
        //$user=new User();
        $user= $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id_user);
 

 $annonce->setTitle($title);
 $annonce->setPrice($price);
 $annonce->setDescription($description);
 $annonce->setType($type);
 $annonce->setAdresse($adresse);
 $annonce->setUser($user);
 $annonce->setCategory($category);
  $annonce->setSubCategory($subcategory);
  $manager=$this->getDoctrine()->getManager();

    $manager->persist($annonce);
    $manager->flush();
       


$targetDir = "annonceImg/";

if(!empty(array_filter($_FILES['imgAn']['name']))){
  $catalog =new Catalogue();
        foreach($_FILES['imgAn']['name'] as $key=>$val){
            // File upload path
            $fileName = basename($_FILES['imgAn']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

        move_uploaded_file($_FILES["imgAn"]["name"][$key], $targetFilePath);
 $catalog =new Catalogue();
           $catalog->setAnnonce($annonce);
           $catalog->setUrlimg($targetFilePath);
           $manager->persist($catalog);
           $manager->flush();


          }


        }

         
          return $this->redirectToRoute('category');
          }
          /**
     * @Route("user/delete/{id}", name="userDeletann")
     */

    public function destroy($id)
    {

        $anId = $id;

        $conn = $this->getDoctrine()->getManager()->getConnection();
      
        $req='delete from catalogue where annonce_id='. $anId;



        
        
        $resreq=$conn->prepare($req);
        
        $resreq->execute();
        $annonce = $this->getDoctrine()
        ->getRepository(Annonces::class)
        ->find($id);
        $user=$annonce->getUser();
         $manager=$this->getDoctrine()->getManager();
         $manager->remove($annonce);
         $manager->flush();
         
          
        
        return $this->redirectToRoute('myads',[
            'id' => $user->getId(),
        ]);
    }
}
