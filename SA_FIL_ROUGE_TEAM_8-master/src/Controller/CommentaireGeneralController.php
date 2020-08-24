<?php

namespace App\Controller;

use App\Entity\FilDeDuscussion;


use App\Entity\CommentaireGeneral;
use App\Repository\UserRepository;
use App\Repository\PromoRepository;
use App\Repository\FilDeDiscussionRepository;
use App\Repository\CommentaireGeneralRepositor;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommentaireGeneralController extends AbstractController
{
    /**
     * @Route("/commentaire/general", name="commentaire_general")
     */
    public function index()
    {
        return $this->render('commentaire_general/index.html.twig', [
            'controller_name' => 'CommentaireGeneralController',
        ]);
    }

    /**
     * @Route(
     * name="getChatByApprenantDunPromo",
     * path="api/admin/promo/{idPro}/apprenant/{id}/chats",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\CommentaireGeneralController::getChatByApprenantDunPromo",
     * "_api_resource_class"=CommentaireGeneral::class,
     * "_api_collection_operation_name"="get_ChatByApprenantDunPromo"
     * }
     * )
     */
    public function getChatByApprenantDunPromo(UserRepository $User,FilDeDiscussionRepository $FilDeD,PromoRepository $promRepo,SerializerInterface $serializer,$id,$idPro)
    {
        
        $promo=$promRepo->find($idPro);
       $filDeDiscussions=$promo->getFilDeDiscussions();

       foreach ($filDeDiscussions as $filDeDiscussion) {
           foreach($filDeDiscussion->getCommentaireGenerals() as $commentaireGeneral){
               $commentaire=$commentaireGeneral->getUser();

               if ($commentaire->getRoles()[0]=="ROLE_APPRENANT") { 
                   $tabCmnt[]=$commentaireGeneral;  
               }

           }
        }
                foreach ($tabCmnt as $commentaire) {
                    $date=$commentaire->getDate();
                    $tabDate[]=$date;
                }
                for ($i=0; $i<count($tabDate); $i++) {
                
                    foreach ($tabCmnt as  $com) {
                        if ($com->getDate()->format("d-m-Y")==$tabDate[$i]->format("d-m-Y")) {
        
                            $tableau[$i][]=$com;
                        }
                    }
                    
                }
                
                $comJson =$serializer->serialize($tableau,"json");
                return new JsonResponse($comJson,Response::HTTP_OK,[],true);
        

        
           
}

           /**
     * @Route(
     * name="postChatByApprenantDunPromo",
     * path="api/admin/promo/{idPro}/apprenant/{id}/chats",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\CommentaireGeneralController::postChatByApprenantDunPromo",
     * "_api_resource_class"=CommentaireGeneral::class,
     * "_api_collection_operation_name"="post_ChatByApprenantDunPromo"
     * }
     * )
     */



    public function postChatByApprenantDunPromo()
     {
        dd("ok");
    
    
}
}

        
    
     
  



 
