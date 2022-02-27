<?php
namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Niveau;

/**
 * Description of AccueilController
 *
 * @author emds
 */
class AccueilController extends AbstractController{
    
    /**
     *
     * @var FormationRepository
     */
    private $repository;
    
    /**
     * 
     * @param FormationRepository $repository
     */
    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }    
    
    /**
     * Retourne les n dernières formations ajoutées
     * @Route("/", name="accueil")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->repository->findAllLasted(2);
        $niveauRepository = $this->getDoctrine()->getManager()->getRepository(Niveau::class);
        $niveaux = $niveauRepository->findAll();
        return $this->render("pages/accueil.html.twig", [
            'formations' => $formations,
            'niveaux' => $niveaux
        ]);  
    }
}
