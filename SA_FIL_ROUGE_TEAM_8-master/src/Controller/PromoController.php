<?php
namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Groupe;
use App\Entity\Promo;
use App\Repository\ApprenantRepository;
use App\Repository\GroupeRepository;
use App\Repository\ProfilSortieRepository;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\FormateurRepository;
use App\Repository\ProfilRepository;
use App\Repository\PromoRepository;
use App\Repository\ReferentielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PromoController extends AbstractController{



    /**
     * @Route(
     * name="add_Promo",
     * path="/admin/promo",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\PromoController::index",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="post_Promo"
     * }
     * )
     */
    public function index(UserPasswordEncoderInterface $encoder,ProfilRepository $profilRepo,Request $request,PromoRepository $repoPromo,ReferentielRepository $repoRefer,FormateurRepository $formRepo,SerializerInterface $serializer, \Swift_Mailer $mailer)
    {
        $profFormateur=$profilRepo->find(2);
        $promoAjout=json_decode($request->getContent(),true);
        $promo=new Promo();
        $this->denyAccessUnlessGranted('POST_EDIT',$promo);

        $groupeAdd=json_decode($request->getContent(),true);
        $promo->setLangue($promoAjout['langue']);
        $promo->setTitre($promoAjout['titre']);
        $promo->setDescription($promoAjout['description']);
        $promo->setLieu($promoAjout['lieu']);
        $promo->setDateDebut(new \DateTime());
        $promo->setDateFinProvisoire(new \DateTime());
        $promo->setDateFinReelle(new \DateTime());
        $promo->setFabrique($promoAjout['fabrique']);
        $promo->setEtat($promoAjout['etat']);

        $profil=$profilRepo->find(1);
                $referentiel=$repoRefer->find($promoAjout['referentiel']);
                if($referentiel){
                    $promo->setReferentiel($referentiel);
                }
        if(isset($promoAjout['formateurs'])){
            foreach ($promoAjout['formateurs'] as $key){
                $formateur=$formRepo->find($key['id']);
                if($formateur){
                    $promo->addFormateur($formateur);
                }
            }
        }

        if(isset($promoAjout['groupes'])){
            foreach ($promoAjout['groupes'] as $key){
                $groupe=new Groupe();
                $groupe->setNom($key['nom']);
                $groupe->setStatut($key['statut']);
                $groupe->setType($key['type']);
                $groupe->setDateCreation(new \DateTime());
                if(is_string($key['apprenants'])){
                        $tab=explode(";",$key['apprenants']);
                }else{
                    $tab=array();
                    foreach ($key['apprenants'] as $val){
                        $tab[]=$val['email'];
                    }

                   $tab=array_values($tab);
                }
                foreach ($tab as $apprenantsCreate){
                    $apprenant=new Apprenant();
                    $apprenant->setProfil($profil);
                    $apprenant->setEmail($apprenantsCreate);
                    $apprenant->setArchivage(1);
                    $apprenant->setIsConnected(false);
                    $passwords=$this->genererPassword(8);
                    $apprenant->setPassword($encoder->encodePassword($apprenant,$passwords));
                    $message = (new \Swift_Message('Coordonnées de connexion '))
                        ->setFrom('sac3g8@gmail.com')
                        ->setTo($apprenantsCreate)
                        ->setBody(
                            $this->renderView(
                            // templates/emails/registration.html.twig
                                'base.html.twig',
                                ['name' => $apprenantsCreate,
                                    'password'=>$passwords]
                            ),
                            'text/html'
                        )
                        // you can remove the following code if you don't define a text version for your emails

                    ;

                    $mailer->send($message);
                    // return $this->render(...);


                    $groupe->addApprenant($apprenant);
                }
                if(isset($key['formateurs'])){
                foreach ($key['formateurs'] as $frmtrs){
                    if(isset($frmtrs['id'])){
                        $formateurss=$formRepo->find($frmtrs['id']);

                        $groupe->addFormateur($formateurss);

                    }
                }
            }
                $promo->addGroupe($groupe);

            }
        }





        $ems=$this->getDoctrine()->getManager();
        $ems->persist( $promo);
        $ems->flush();
       // $promoAjoute =$serializer->serialize($promo,"json");
        return new JsonResponse('ok',Response::HTTP_OK,[],true);
    }

    private function genererPassword($nbChar){
        return substr(str_shuffle(
            'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789'),1, $nbChar); }


    /**
     * @Route(
     * name="get_Groupe_Principal_promos",
     * path="admin/promos/principal",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getGroupePrincipal",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="get_Groupe_Principals_promo_apprenants"
     * }
     * )
     */
    public function getGroupePrincipal(GroupeRepository $grp,PromoRepository $promRepo,SerializerInterface $serializer)
    {
       // dd('ok0');
        $grps=$grp->findBy(['type'=>'principal']);


        $promoAjoute =$serializer->serialize($grps,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="get_ApprenantByProfilDeSortiePromo",
     * path="api/admin/promo/{idPro}/profilDeSortie/{id}/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getApprenantByProfilDeSortiePromo",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="getApprenantByProfilDeSortiePromo"
     * }
     * )
     */
    public function getApprenantByProfilDeSortiePromo(GroupeRepository $grp,PromoRepository $promRepo,SerializerInterface $serializer,$id,$idPro)
    {
        $promo=$promRepo->find($idPro);
        $groupes=($promo->getGroupe());
        foreach ($groupes as $groupe){
            foreach($groupe->getApprenant() as $apprenant){
               $profilSortie=$apprenant->getProfilSortie();

               if($profilSortie->getId()!=$id){
                   $groupe->removeApprenant($apprenant);
               }
            }
        }

        $promoAjoute =$serializer->serialize($groupes,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="updateProfilSortieOne",
     * path="api/admin/promo/{id}/apprenants/{idApp}/profilDeSortie",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\PromoController::updateProfilSortieOne",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="putProfilSortie"
     * }
     * )
     */
    public function updateProfilSortieOne(ApprenantRepository $appr,Request $request,ProfilSortieRepository $profilSortieRepository,PromoRepository $promRepo,SerializerInterface $serializer,$id,$idApp)
    {
        $all=$request->getContent();
        $all=json_decode($all,true);
        $profSort=$profilSortieRepository->find($all['id']);
        $apprenant=$appr->find($idApp);
        $apprenant->setProfilSortie($profSort);
        $em=$this->getDoctrine()->getManager();
        $em->persist($apprenant);
        $em->flush();



        $promoAjoute =$serializer->serialize($apprenant,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="updateProfilSortieAll",
     * path="api/admin/promo/{id}/apprenants/profilDeSortie",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\PromoController::updateProfilSortieAll",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="putProfilSortieAll"
     * }
     * )
     */
    public function updateProfilSortieAll(ApprenantRepository $appr,Request $request,ProfilSortieRepository $profilSortieRepository,PromoRepository $promRepo,SerializerInterface $serializer,$id)
    {
        $all=$request->getContent();
        $all=json_decode($all,true);
        $profSort=$profilSortieRepository->find($all['id']);
        $promo=$promRepo->find($id);
        $groupes=($promo->getGroupe());
        foreach ($groupes as $groupe){
            foreach($groupe->getApprenant() as $apprenant){
           $apprenant->setProfilSortie( $profSort);

            }
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($promo);
        $em->flush();



        $promoAjoute =$serializer->serialize($promo,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }




    /**
     * @Route(
     * name="get_one_promo_encours",
     * path="api/admin/promo/{id}/encours",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getOneEncours",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="get_enCoursOne"
     * }
     * )
     */
    public function getOneEncours(PromoRepository $promRepo,SerializerInterface $serializer,$id)
    {
        $promo=$promRepo->find($id);


        $promoAjoute =$serializer->serialize($promo,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="get_one_promo_referentiels",
     * path="api/admin/promo/{id}/referentiels",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getOneEncours",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="get_Promo_Referentiel"
     * }
     * )
     */
    public function getPromoReferentiel(PromoRepository $promRepo,SerializerInterface $serializer,$id)
    {
        $promo=$promRepo->find($id);

$ref=($promo->getReferentiel());
//dd($ref->getGroupeCompetences());
        $promoAjoute =$serializer->serialize($ref,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }





    /**
     * @Route(
     * name="listerFormateursGet",
     * path="api/admin/promo/{id}/formateurs",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getFormateurs",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="getFormateurs"
     * }
     * )
     */
    public function getFormateurs(PromoRepository $promRepo,SerializerInterface $serializer,$id)
    {
        $promo=$promRepo->find($id);
        $appre=$promo->getFormateur();

        $promoAjoute =$serializer->serialize($appre,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }






    /**
     * @Route(
     * name="get_Attente_promo_referentiels",
     * path="api/admin/promo/{id}/apprenants/attente",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getOneEncours",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="get_Attente_Referentiel"
     * }
     * )
     */
    public function getAttentePromoRefe(PromoRepository $promRepo,SerializerInterface $serializer,$id)
    {
        $promo=$promRepo->find($id);

        $ref=($promo->getGroupe());
$grps=($ref->getValues());
foreach ($grps as $key){
    if($key->getType()=="principal"){
        $myGroupe=$key;
    }
}
$tabAppr=array();

$apprenant=($myGroupe->getApprenant());
foreach($apprenant as $appr){
    if($appr->getIsConnected()==false){
        $tabAppr[]=$appr;
    }
}
        $promoAjoute =$serializer->serialize($tabAppr,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="get_one_promo_principal",
     * path="api/admin/promo/{id}/principal",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getOnePrincipal",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="get_One_Principal"
     * }
     * )
     */
    public function getOnePrincipal(PromoRepository $promRepo,SerializerInterface $serializer,$id)
    {
        $promo=$promRepo->find($id);
$groupes=$promo->getGroupe();
foreach ($groupes as $groupe){
    if($groupe->getType()=="principal"){
        $groupePrincipal=$groupe;

    }
}


        $groupeAPr =$serializer->serialize($groupePrincipal,"json");
        return new JsonResponse($groupeAPr,Response::HTTP_OK,[],true);
    }




    /**
     * @Route(
     * name="modifierStatutGroupe",
     * path="api/admin/promo/{id}/groupes/{idG}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\PromoController::modifierStatutGroupe",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="put_statut_groupe"
     * }
     * )
     */
    public function modifierStatutGroupe(PromoRepository $promRepo,GroupeRepository $grps,SerializerInterface $serializer,$id,$idG,Request $request)
    {
        $statut=json_decode($request->getContent(),true);
        $groupe=$grps->find($idG);
       // dd($statut['statut']);
        $groupe->setStatut($statut['statut']);
        $em=$this->getDoctrine()->getManager();
        $em->persist($groupe);
        $em->flush();



       // $groupeAPr =$serializer->serialize($groupe,"json");
        return new JsonResponse('ok',Response::HTTP_OK,[],true);
    }







    /**
     * @Route(
     * name="addDeleteApprenant",
     * path="api/admin/promo/{id}/apprenants",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\PromoController::addDeleteApprenantPromo",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="putAddDeleteApprenant"
     * }
     * )
     */
    public function addDeleteApprenantPromo( ApprenantRepository $apprenantRepo, ProfilRepository $profilRepo,UserPasswordEncoderInterface $encoder, PromoRepository $promRepo,GroupeRepository $grps,SerializerInterface $serializer,$id,Request $request)
    {
        $mods=json_decode($request->getContent(),true);
        $promoModifier=$promRepo->find($id);
$i=0;
        $profil=$profilRepo->find(1);
for($j=0;$j<count($mods['apprenants']);$j++){
    if(isset($mods['apprenants'][$j]['id'])){
        $apprenantDel=$apprenantRepo->find($mods['apprenants'][$j]['id']);
        $groupe= $promoModifier->getGroupe();
        foreach($groupe->getValues() as $keys){

            if($keys->getType()=="principal"){
                $keys->removeApprenant($apprenantDel);
            }
        }
    }else{
        $apprenant=new Apprenant();
        $apprenant->setEmail($mods['apprenants'][$j]['email']);
        $apprenant->setIsConnected(false);
        $apprenant->setPassword($encoder->encodePassword($apprenant,'password'));
        $apprenant->setProfil($profil);
        $groupe= $promoModifier->getGroupe();
        foreach($groupe->getValues() as $keys){
            if($keys->getType()=="principal"){

                $keys->addApprenant($apprenant);
            }
        }
    }
}

        $em=$this->getDoctrine()->getManager();
        $em->persist($promoModifier);
        $em->flush();


        // $groupeAPr =$serializer->serialize($groupe,"json");
        return new JsonResponse('ok',Response::HTTP_OK,[],true);
    }








    /**
     * @Route(
     * name="addDeleteFormateur",
     * path="api/admin/promo/{id}/formateurs",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\PromoController::addDeleteFormateurPromo",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="putAddDeleteFormateur"
     * }
     * )
     */
    public function addDeleteFormateurPromo( FormateurRepository $formateurRepo, ProfilRepository $profilRepo,UserPasswordEncoderInterface $encoder, PromoRepository $promRepo,GroupeRepository $grps,SerializerInterface $serializer,$id,Request $request)
    {
        $mods=json_decode($request->getContent(),true);
        $promoModifier=$promRepo->find($id);
        $i=0;
        $profil=$profilRepo->find(2);
    for ($j=0;$j<count($mods['formateurs']);$j++){
        if(isset($mods['formateurs'][$j]['id'])){
             $formateurDel=$formateurRepo->find($mods['formateurs'][$j]['id']);
            $promoModifier->removeFormateur($formateurDel);

        }else{
            $formateur=new Formateur();
            $formateur->setEmail($mods['formateurs'][$j]['email']);
            $formateur->setNom($mods['formateurs'][$j]['nom']);
            $formateur->setPrenom($mods['formateurs'][$j]['prenom']);
            $formateur->setTelephone($mods['formateurs'][$j]['telephone']);
            $formateur->setLogin($mods['formateurs'][$j]['login']);
            $formateur->setAdresse($mods['formateurs'][$j]['adresse']);
            $formateur->setStatus($mods['formateurs'][$j]['statut']);
            $formateur->setGenre($mods['formateurs'][$j]['genre']);


            $formateur->setPassword($encoder->encodePassword($formateur,'password'));
            $formateur->setProfil($profil);
            $promoModifier->addFormateur($formateur);
        }
}


        $em=$this->getDoctrine()->getManager();
        $em->persist($promoModifier);
        $em->flush();

       // dd($promoModifier);

        // $groupeAPr =$serializer->serialize($groupe,"json");
        return new JsonResponse('ok',Response::HTTP_OK,[],true);
    }




    /**
     * @Route(
     * name="get_liste_attente_promo",
     * path="/admin/promo/apprenants/attente",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::listeAttente",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="get_liste_attente"
     * }
     * )
     */
    public function listeAttente(ApprenantRepository $appre,PromoRepository $promRepo,SerializerInterface $serializer)
    {
        $apprenants=$appre->findBy(["isConnected"=>false]);
      //  dd($apprenants);
       /* $promo=$promRepo->findBy(["etat"=>1]);
        $ui=array();
$listeAttente=array();
foreach ($promo as $keys){
    $po=$keys->getGroupe();
    $oi= $po->getValues();
    foreach ($oi as $all) {
        $ui[]=$all->getApprenant();

    }
}
             foreach ($ui as $key){
                dd($key->getValues());
                if($key->getValues()->getIsConnected()==false){
                    $listeAttente[]=$key;

                }
            }
dd($listeAttente);*/
        $promoAjoute =$serializer->serialize($apprenants,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }







    /**
     * @Route(
     * name="getApprenantByGrpes",
     * path="api/admin/promos/{idPro}/groupes/{id}/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getApprenantByGrpes",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="getApprntByGrpPromo"
     * }
     * )
     */
    public function getApprenantByGrpes(GroupeRepository $grp,PromoRepository $promRepo,SerializerInterface $serializer,$idPro,$id)
    {
        $promo=$promRepo->find($idPro);
            $grps=($promo->getGroupe());
            foreach ($promo->getGroupe() as $key){
                if($key->getId()!=$id){
                    $promo->removeGroupe($key);
                }
            }
         //   dd($grps);
        //dd($promo);
        // dd($promo);
      /*  $listeAttente=array();
        $po=$promo->getGroupe();
        $oi= $po->getValues();
        $ui=$oi[0]->getApprenant();
        foreach ($ui as $key){
            if($key->getIsConnected()==false){
                $listeAttente[]=$key;

            }
        }
*/
        $promoAjoute =$serializer->serialize($promo,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }





    /**
     * @Route(
     * name="get_All_promo_encours",
     * path="api/admin/promo/encours",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\PromoController::getAllPromoEnCours",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="getAllPromoEnCours"
     * }
     * )
     */
    public function getAllPromoEnCours(GroupeRepository $grp,PromoRepository $promRepo,SerializerInterface $serializer)
    {
        $promo=$promRepo->findBy(["etat"=>1]);


        $promoAjoute =$serializer->serialize($promo,"json");
        return new JsonResponse($promoAjoute,Response::HTTP_OK,[],true);
    }
    /**
     * @Route(
     * name="updatePromoRef",
     * path="api/admin/promo/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\PromoController::updatePromoReferentiel",
     * "_api_resource_class"=Promo::class,
     * "_api_item_operation_name"="putPromoReferent"
     * }
     * )
     */
    public function updatePromoReferentiel(ReferentielRepository $refRepo,Request $request,PromoRepository $promRepo,SerializerInterface $serializer,$id)
    {
        $promo=$promRepo->find($id);
        $aMod=json_decode($request->getContent(),true);
        if(isset($aMod['langue'])){
            $promo->setLangue($aMod['langue']);
        }
        if(isset($aMod['titre'])){
            $promo->setTitre($aMod['titre']);
        }
        if(isset($aMod['description'])){
            $promo->setDescription($aMod['description']);
        }
        if(isset($aMod['lieu'])){
            $promo->setLieu($aMod['lieu']);
        }
        if(isset($aMod['fabrique'])){
            $promo->setFabrique($aMod['fabrique']);
        }
        if(isset($aMod['etat'])){
            $promo->setEtat($aMod['etat']);
        }
        if(isset($aMod['referentiel'])){
           $reFA= $refRepo->find($aMod['referentiel']['id']);

            $promo->setReferentiel($reFA);
        }
       $em=$this->getDoctrine()->getManager();
        $em->persist($promo);
        $em->flush();

     //   $promoAjoute =$serializer->serialize($promo,"json");
        return new JsonResponse("ok",Response::HTTP_OK,[],true);
    }




}