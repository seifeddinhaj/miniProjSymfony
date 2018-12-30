<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categories;
use App\Entity\Subcategory;
use App\Entity\User;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        

$conn = $this->getDoctrine()->getManager()->getConnection();
        $sql = 'select user.name,annonces.*,categories.type as cat,subcategory.type as sub
                from annonces,user,categories,subcategory
                 where user.id=annonces.user_id and 
                annonces.category_id=categories.id and
                 annonces.sub_category_id=subcategory.id';
        $q=$conn->prepare($sql);
        $q->execute(); 
       


        return $this->render('admin/index.html.twig', [
            'q' => $q,
        ]);
    }
     /**
     * @Route("/adminCategories", name="adminCategories")
     */
    public function admincat()

    {
 $cat= $this->getDoctrine()
        ->getRepository(Categories::class)
        ->findAll();

        return $this->render('admin/adminCatego.html.twig', [
            'cat' => $cat,
        ]);
    }
     /**
     * @Route("/adminSubCat", name="adminSubCat")
     */
    public function adminsubcat()


     {

       
        $sub= $this->getDoctrine()
        ->getRepository(Subcategory::class)
        ->findAll();
 $cat= $this->getDoctrine()
        ->getRepository(Categories::class)
        ->findAll();


        return $this->render('admin/adminSubCat.html.twig', array(
            'cat' => $cat,
            'sub'=>$sub,
        ));
    }


     /**
     * @Route("/adminUsers", name="adminUsers")
     */
    public function adminusers()


    {
     $cat= $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();


       return $this->render('admin/adminUsers.html.twig', [
            'user' => $cat,
        ]);
    }


    /**
     * @Route("add/delete", name="adminDeletann")
     */

    public function destroy(Request $request)
    {

        $userid = $request->request->get('id');
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $req='delete from catalogue where annonce_id='. $userid;
        $req1='delete from annonces where id='.$userid;

        $resreq=$conn->prepare($req);
        $resreq1=$conn->prepare($req1);
       
        $resreq->execute();
         $resreq1->execute();
        
        return $this->redirectToRoute('admin');
    }
}
