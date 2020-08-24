<?php
namespace App\Controller;

use App\Entity\Competence;
use App\Entity\GroupeCompetences;
use App\Repository\CompetenceRepository;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeCompetenceController extends AbstractController{

    /**
     * @Route(
     * name="put_groupeCompetenceCpt",
     * path="/admin/grpecompetences/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\GroupeCompetenceController::updateGroupeCompetenceCompt",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="put_grpe_cptence"
     * }
     * )
     */
    public function updateGroupeCompetenceCompt(CompetenceRepository $compet,GroupeCompetencesRepository $repo,SerializerInterface $serializer,Request $request,$id)
    {
        $grpeCompetences=$repo->find($id);
       // $grpeCompetencess=new GroupeCompetences();
//dd($grpeCompetences);
        $this->denyAccessUnlessGranted('PUT_GRPE',$grpeCompetences,'héééééééééé fo dieum' );
        $r=json_decode($request->getContent(),true);
//dd($r);
            if(isset($r["libelle"])){
                $grpeCompetences->setLibelle($r['libelle']);
            }
        if(isset($r["descriptif"])){
            $grpeCompetences->setDescriptif($r['descriptif']);
        }
        //dd($grpeCompetences);

        $grpeCompetences->setLibelle($r['libelle']);
        $grpeCompetences->setDescriptif($r['descriptif']);
        if(isset($r['competence'])){
            foreach ($r['competence'] as $competence){
                if(isset( $competence['id']) && isset( $competence['libelle'])){
                    $competModif=$compet->find($competence['id']);
                    $competModif->setLibelle($competence['libelle']);
                 //   $grpeCompetences->addCompetence($competModif);

                }
                if(!isset( $competence['id']) && isset( $competence['libelle'])){
                    $cpt=new Competence();
                    $cpt->setLibelle($competence['libelle']);
                    $grpeCompetences->addCompetence($cpt);
                }
                if(isset( $competence['id']) && !isset( $competence['libelle'])){
                    $competSupp=$compet->find($competence['id']);
                    $bool=false;
                    foreach ( $grpeCompetences->getCompetence()->getValues() as $key){
                        if($key->getId()==$competSupp->getId()){
                            $bool=true;
                        }
                    }
                        if($bool==true){
                            $grpeCompetences->removeCompetence($competSupp);
                        }else{
                            $grpeCompetences->addCompetence($competSupp);
                        }


                }

            }
        }



        //dd($grp);
        $em= $this->getDoctrine()->getManager();
        $em->persist($grpeCompetences);
        $em->flush();
        dd('ok');
        //  $p=$serializer->deserialize($request->getContent(),GroupeCompetences::class,'');
        dd($p);
        $grpeJson =$serializer->serialize($cptces,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="post_groupeCompetenceCpt",
     * path="/admin/grpecompetences",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\GroupeCompetenceController::addGroupeCompetenceCompt",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="post_grpe_cptence"
     * }
     * )
     */
    public function addGroupeCompetenceCompt(GroupeCompetencesRepository $repo,SerializerInterface $serializer,Request $request)
    {
        $grpeCompetences=new GroupeCompetences();

        $this->denyAccessUnlessGranted('POST_GROUPE',$grpeCompetences,'héééééééééé fo dieum' );
        $r=json_decode($request->getContent(),true);
        $grpeCompetences->setLibelle($r['libelle']);
        $grpeCompetences->setDescriptif($r['descriptif']);
        if(isset($r['competence'])){
            foreach ($r['competence'] as $competence){
                $cpt=new Competence();
                $cpt->setLibelle($competence['libelle']);
                $grpeCompetences->addCompetence($cpt);
            }
        }


        $em= $this->getDoctrine()->getManager();
        $em->persist($grpeCompetences);
        $em->flush();
        dd('ok');
      //  $p=$serializer->deserialize($request->getContent(),GroupeCompetences::class,'');
       dd($p);
        $grpeJson =$serializer->serialize($cptces,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }





    /**
     * @Route(
     * name="groupeCompetence_liste_competces",
     * path="/admin/grpecompetences/competences",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\GroupeCompetenceController::listerGroupeCompetenceCompt",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_groupeCompetence_liste_cptences"
     * }
     * )
     */
    public function listerGroupeCompetenceCompt(GroupeCompetencesRepository $repo,SerializerInterface $serializer)
    {
        $grpeCompetences=new GroupeCompetences();
        $this->denyAccessUnlessGranted('GET_COMPETENCES',$grpeCompetences,'héééééééééé fo dieum' );
        $grpeObject=$repo->findAll();
        $cptces=array();
        foreach ($grpeObject as $key){
            if($key->getCompetence()!=""){
                $cptces[]= $key->getCompetence();

            }
        }
        $grpeJson =$serializer->serialize($cptces,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="groupeCompetence_liste",
     * path="/admin/grpecompetences",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\GroupeCompetenceController::listerGroupeCompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_groupeCompetence_liste"
     * }
     * )
     */
    public function listerGroupeCompetence(GroupeCompetencesRepository $repo,SerializerInterface $serializer)
    {
        $grpeCompetences=new GroupeCompetences();
        $this->denyAccessUnlessGranted('GET',$grpeCompetences);
        $grpeObject=$repo->findAll();
        $grpeJson =$serializer->serialize($grpeObject,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }


    /**
     * @Route(
     * name="get_groupeCompetenceOne",
     * path="/admin/grpecompetences/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\GroupeCompetenceController::getOneGroupeCompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_item_operation_name"="getOneGroupeCompetence"
     * }
     * )
     */
    public function getOneGroupeCompetence(GroupeCompetencesRepository $repo,SerializerInterface $serializer,$id)
    {
        $grpeCompetences=new GroupeCompetences();
        $this->denyAccessUnlessGranted('GET_ONE',$grpeCompetences);
        $grpeObject=$repo->find($id);
        $grpeJson =$serializer->serialize($grpeObject,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }
    /**
     * @Route(
     * name="get_CompetenceByGrp",
     * path="/admin/grpecompetences/{id}/competences",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\GroupeCompetenceController::getCompetenceByGrp",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_item_operation_name"="getCompetenceByGroupeCompetence"
     * }
     * )
     */
    public function getCompetenceByGrp(GroupeCompetencesRepository $repo,SerializerInterface $serializer,$id)
    {
        $grpeCompetences=new GroupeCompetences();
        $this->denyAccessUnlessGranted('GET_COMPETENCE',$grpeCompetences);
        $grpeObject=$repo->find($id);
        $cpt=$grpeObject->getCompetence();
        $grpeJson =$serializer->serialize($cpt,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }
}