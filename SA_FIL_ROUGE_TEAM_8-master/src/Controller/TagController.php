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

class TagController extends AbstractController{

    /**
     * @Route(
     * name="post_Tag",
     * path="/admin/tags",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\TagController::addTag",
     * "_api_resource_class"=Tag::class,
     * "_api_collection_operation_name"="postTag"
     * }
     * )
     */
    public function addTag(GroupeTagRepository $repo,SerializerInterface $serializer,Request $request,TagRepository $tagRepo)
    {
        $tg=new Tag();
       $this->denyAccessUnlessGranted('POST_EDIT',$tg,'Acces non autorisé' );

        $myTag=json_decode($request->getContent(),true);
        $tagPost=new Tag();
        $tagPost->setLibelle($myTag['libelle']);
        $tagPost->setDescriptif($myTag['descriptif']);
        if(isset($myTag['groupeTags'])){
            foreach ($myTag['groupeTags'] as $new){
                if(isset($new['id'])){
                    $grpeTaggS=$repo->find($new['id']);
                    $tagPost->addGroupeTag($grpeTaggS);
                }
        }
        }

        $em= $this->getDoctrine()->getManager();
        $em->persist($tagPost);
        $em->flush();

       // dd('ok');
        //  $p=$serializer->deserialize($request->getContent(),GroupeCompetences::class,'');
       // dd($p);
        $grpeJson =$serializer->serialize($tagPost,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);

    }
    /**
     * @Route(
     * name="put_Tag",
     * path="/admin/tags/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="App\Controller\TagController::putTag",
     * "_api_resource_class"=Tag::class,
     * "_api_collection_operation_name"="putTag"
     * }
     * )
     */
    public function putTag(GroupeTagRepository $repo,SerializerInterface $serializer,Request $request,TagRepository $tagRepo,$id)
    {
        $myTag=json_decode($request->getContent(),true);
        $puttingTag=$tagRepo->find($id);

       if(isset($myTag['libelle'])){
           $puttingTag->setLibelle($myTag['libelle']);

       }
if(isset($myTag['descriptif'])){
    $puttingTag->setDescriptif($myTag['descriptif']);

}
        if(isset($myTag['groupeTags'])){
            foreach ($myTag['groupeTags'] as $new){
                if(isset($new['id'])){
                    $grpeTaggS=$repo->find($new['id']);
                    $puttingTag->addGroupeTag($grpeTaggS);
                }
            }
        }

        $em= $this->getDoctrine()->getManager();
        $em->persist($puttingTag);
        $em->flush();
        //    $this->denyAccessUnlessGranted('POST_GROUPE',$grpeCompetences,'héééééééééé fo dieum' );

        //dd('ok');
        //  $p=$serializer->deserialize($request->getContent(),GroupeCompetences::class,'');
        //dd($p);
        $grpeJson =$serializer->serialize($puttingTag,"json");
        return new JsonResponse($grpeJson,Response::HTTP_OK,[],true);
    }
}