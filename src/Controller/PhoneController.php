<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Phone;
use App\Repository\PhoneRepository;
use ContainerPuP5l9S\PaginatorInterface_82dac15;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\SecurityContext;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/api")
 */
class PhoneController extends AbstractController
{
    /**
     * @Route("/phones", name="phones", methods={"GET"})
     */
    public function listPhones(PhoneRepository $phoneRepository, Request $request, PaginatorInterface $paginator): Response
    {
        if (!$phoneRepository->findAll()) {
            return $this->json([
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Aucun téléphone n'existe"
            ], Response::HTTP_BAD_REQUEST);
        }

        $phones = $paginator->paginate(
            $phoneRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
       
        return $this->json($phones, Response::HTTP_OK, [], ['groups' => 'list_phones']);
    }

    /**
     * @Route("/phones/{id<[0-9]+>}", name="phone", methods={"GET"})
     */
    public function showPhone(Phone $phone)
    {
        return $this->json($phone, Response::HTTP_OK, [], ['groups' => 'show_phones']);
    }
}
