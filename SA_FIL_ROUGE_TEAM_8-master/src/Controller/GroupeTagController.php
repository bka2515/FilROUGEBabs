<?php
namespace App\Controller;
use App\Entity\GroupeTag;
use App\Entity\Tag;
use App\Repository\GroupeTagRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeTagController extends AbstractController{

    /**
     * @Route(
     * name="groupeTag_liste_Tag",
     * path="admin/grptags/{id}/tags",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\GroupeTagController::groupeTaglisteTag",
     * "_api_resource_class"=GroupeTag::class,
     * "_api_collection_operation_name"="get_tags_by_liste_tags"
     * }
     * )
     */
    public function groupeTaglisteTag(GroupeTagRepository $repo,SerializerInterface $serializer,$id)
    {
        $grpTags=new GroupeTag();
         $this->denyAccessUnlessGranted('ALL',$grpTags,'Acces non autorisé' );

        $tagsObject=$repo->find($id);
        $tags=$tagsObject->getTag();
        $tagsJson =$serializer->serialize($tags,"json");
        return new JsonResponse($tagsJson,Response::HTTP_OK,[],true);
    }



    /**
     * @Route(
     * name="post_GroupeTagsTag",
     * path="/admin/grptags",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\GroupeTagController::addGroupeTagsTag",
     * "_api_resource_class"=GroupeTag::class,
     * "_api_collection_operation_name"="post_GroupeTagsTag"
     * }
     * )
     */
    public function addGroupeTagsTag(GroupeTagRepository $repo,SerializerInterface $serializer,Request $request)
    {
        $grpeTag=new GroupeTag();
        $this->denyAccessUnlessGranted('ALL',$grpeTag,'Acces non autorisé' );
        $r=json_decode($request->getContent(),true);

        $grpeTag->setLibelle($r['libelle']);
        foreach ($r['tag'] as $tag){
            $newTag=new Tag();
            $newTag->setLibelle($tag['libelle']);
            $newTag->setDescriptif($tag['descriptif']);
            $grpeTag->addTag($newTag);
        }


        //dd($grp);
        $em= $this->getDoctrine()->getManager();
        $em->persist($grpeTag);
        $em->flush();
       // dd('ok');
        //  $p=$serializer->deserialize($request->getContent(),GroupeCompetences::class,'');
       // dd($p);
        $grpeJson =$serializer->serialize($grpeTag,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }
    /**
     * @Route(
     * name="modifier_GroupeTagsTag",
     * path="/admin/grptags/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\GroupeTagController::updatingGroupeTagsTag",
     * "_api_resource_class"=GroupeTag::class,
     * "_api_item_operation_name"="update_GroupeTagsTag"
     * }
     * )
     */
    public function updatingGroupeTagsTag(TagRepository $tagRp,GroupeTagRepository $repo,SerializerInterface $serializer,Request $request,$id)
    {
        $grpeTag=new GroupeTag();
        $this->denyAccessUnlessGranted('ALL',$grpeTag,'Acces non autorisé' );

        $grpTagAModif=json_decode($request->getContent(),true);
        $grpTagg=$repo->find($id);

        if(isset($grpTagAModif['libelle'])){
            $grpTagg->setLibelle($grpTagAModif['libelle']);
        }


                if(isset($grpTagAModif['tag'])){
                    foreach ($grpTagAModif['tag'] as $tag){
                        if(isset($tag['id']) && !isset($tag['descriptif']) && !isset($tag['id'])){
                            $tagSupp=$tagRp->find($tag['id']);
                            $grpTagg->removeTag($tagSupp);
                        }
                        if(isset($tag['libelle']) && isset($tag['descriptif']) && !isset($tag['id'])){
                            $newTag=new Tag();
                            $newTag->setLibelle($tag['libelle']);
                            $newTag->setDescriptif($tag['descriptif']);
                            $grpTagg->addTag($newTag);
                        }

                    }
                }

        $em= $this->getDoctrine()->getManager();
        $em->persist($grpTagg);
        $em->flush();
       // dd('ok');
        //  $p=$serializer->deserialize($request->getContent(),GroupeCompetences::class,'');
       // dd($p);
        $grpeJson =$serializer->serialize($grpTagg,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }
}