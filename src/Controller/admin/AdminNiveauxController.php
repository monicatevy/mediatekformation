<?php
namespace App\Controller\admin;

use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

/**
 * Description of AdminNiveauxController
 *
 * @author monicatevy
 */
class AdminNiveauxController extends AbstractController{
    /**
     *
     * @var NiveauRepository
     */
    private $repository;

    /**
     *
     * @var EntityManagerInterface
     */
    private $om;

    /**
     * 
     * @param NiveauRepository $repository
     * @param EntityManagerInterface $om
     */
    function __construct(NiveauRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }
    
    /**
     * @Route("/admin/niveau/ajout", name="admin.niveau.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        $libelleNiveau = $request->get("libelle");
        $niveau = new Niveau();
        $niveau->setLevel($libelleNiveau);
        $this->om->persist($niveau);
        $this->om->flush();
        return $this->redirectToRoute('admin.niveaux');
    }
    
    /**
     * @Route("/admin/niveau/suppr/{id}", name="admin.niveau.suppr")
     * @param Niveau $niveau
     * @return Response
     */
    public function suppr(Niveau $niveau): Response{
        try{
            $this->om->remove($niveau);
            $this->om->flush();
        }
        catch (ForeignKeyConstraintViolationException $e){
            
        }
        return $this->redirectToRoute('admin.niveaux');
    }
    
    /**
     * @Route("/admin/niveaux", name="admin.niveaux")
     * @return Response
     */
    public function index(): Response{
        $niveaux = $this->repository->findAll();
        return $this->render("admin/admin.niveaux.html.twig", [
            'niveaux' => $niveaux,
        ]);
    }
}