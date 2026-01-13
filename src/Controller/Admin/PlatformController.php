<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Platform;
use App\Form\PlatformType;
use App\Repository\PlatformRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/platform')]
class PlatformController extends AbstractController
{
    #[Route('/', name: 'admin_platform_index', methods: ['GET'])]
    public function index(Request $request, PlatformRepository $repository, PaginatorInterface $paginator): Response
    {
        $query = $repository->findAllQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/platform/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'admin_platform_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $platform = new Platform();
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($platform);
            $em->flush();

            $this->addFlash('success', 'La plateforme a été créée avec succès.');

            return $this->redirectToRoute('admin_platform_index');
        }

        return $this->render('admin/platform/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_platform_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Platform $platform, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'La plateforme a été modifiée avec succès.');

            return $this->redirectToRoute('admin_platform_index');
        }

        return $this->render('admin/platform/edit.html.twig', [
            'platform' => $platform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_platform_delete', methods: ['POST'])]
    public function delete(Request $request, Platform $platform, EntityManagerInterface $em): Response
    {
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $platform->getId(), is_string($token) ? $token : null)) {
            $em->remove($platform);
            $em->flush();

            $this->addFlash('success', 'La plateforme a été supprimée avec succès.');
        }

        return $this->redirectToRoute('admin_platform_index');
    }
}
