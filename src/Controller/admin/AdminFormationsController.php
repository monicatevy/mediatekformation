<?php
namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormationRepository;
use App\Entity\Formation;
use App\Entity\Niveau;
use App\Form\FormationType;

/**
 * Description of AdminFormationsController
 * 
 * @author monicatevy
 */
class AdminFormationsController extends AbstractController{
    
    private const PAGEADMINFORMATIONS = "admin/admin.formations.html.twig";
    
    /**
     *
     * @var FormationRepository
     */
    private $repository;

    /**
     *
     * @var EntityManagerInterface
     */
    private $om;

    /**
     * 
     * @param FormationRepository $repository
     * @param EntityManagerInterface $om
     */
    function __construct(FormationRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }
    
    /**
     * Retourne toutes les formations
     * @Route("/admin/", name="admin.formations")
     * @return Response
     */
    public function index(): Response {
        $formations = $this->repository->findAll();
        $niveauRepository = $this->getDoctrine()->getManager()->getRepository(Niveau::class);
        $niveaux = $niveauRepository->findAll();
        return $this->render(self::PAGEADMINFORMATIONS, [
            'formations' => $formations,
            'niveaux' => $niveaux
        ]);
    }
    
    /**
     * Retourne les formations triées (ASC/DESC) sur le champ (ex: date, titre)
     * @Route("/admin/formations/tri/{champ}/{ordre}", name="admin.formations.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response{
        $formations = $this->repository->findAllOrderBy($champ, $ordre);
        $niveauRepository = $this->getDoctrine()->getManager()->getRepository(Niveau::class);
        $niveaux = $niveauRepository->findAll();
        return $this->render(self::PAGEADMINFORMATIONS, [
           'formations' => $formations,
           'niveaux' => $niveaux
        ]);
    }   
        
    /**
     * Retourne toutes les formations contenant une certaine valeur
     * ou retourne toutes les formations triées par défaut si aucune valeur n'est saisie
     * @Route("/admin/formations/recherche/{champ}", name="admin.formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findAllContain($champ, Request $request): Response{
        if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
            $valeur = $request->get("recherche");
            $formations = $this->repository->findByContainValue($champ, $valeur);
            $niveauRepository = $this->getDoctrine()->getManager()->getRepository(Niveau::class);
            $niveaux = $niveauRepository->findAll();
            return $this->render(self::PAGEADMINFORMATIONS, [
                'formations' => $formations,
                'niveaux' => $niveaux
            ]);
        }
        return $this->redirectToRoute("admin.formations");
    }
    
    /**
     * Retourne le détail d'une formation
     * @Route("/admin/formation/{id}", name="admin.formation.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $formation = $this->repository->find($id);
        return $this->render("admin/admin.formation.html.twig", [
            'formation' => $formation
        ]);        
    }
    
    /**
     * Redirection vers la page d'ajout d'une nouvelle formation
     * @Route("/admin/ajout/", name="admin.formation.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        $formation = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);
        $formFormation->handleRequest($request);
        
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->om->persist($formation);
            $this->om->flush();
            $this->addFlash('success',
                'La formation a été ajouté avec succès.'
            );
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);
    }
    
    /**
     * Redirection vers la page d'édition d'une formation
     * @Route("/admin/edit/{id}", name="admin.formation.edit")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function edit(Formation $formation, Request $request): Response {
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->om->flush();
            $this->addFlash('success',
                'La formation a été modifiée avec succès.'
            );
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.edit.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);
    }
    
    /**
     * Suppression d'une formation après confirmation par l'utilisateur
     * @Route("/admin/suppr/{id}", name="admin.formation.suppr")
     * @param Formation $formation
     * @return Response
     */
    public function suppr(Formation $formation): Response{
        $this->om->remove($formation);
        $this->om->flush();
        $this->addFlash('success',
                'La formation a été supprimée avec succès.'
            );
        return $this->redirectToRoute('admin.formations');
    }
}
