<?php

namespace App\Controller\Admin;

use App\Entity\CityWithCategory;
use App\Entity\UserComment;
use App\Entity\UserLog;
use App\Service\UserLogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller\Admin
 * @Route("/admin")
 */
class IndexController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="admin")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render('admin/index/index.html.twig', [
            'logs' => $this->em->getRepository(UserLog::class)->findByNowDay($request)
        ]);
    }

    public function header(): Response
    {
        $commentCount = $this->em->getRepository(UserComment::class)->findBy(['is_active' => false]);
        return $this->render('admin/includes/header.html.twig', [
            'commentCount' => count($commentCount),
        ]);
    }
}
