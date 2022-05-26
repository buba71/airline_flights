<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\City;
use App\Entity\Flight;
use App\Form\CityType;
use App\Form\FlightType;
use App\Repository\CityRepository;
use App\Repository\FlightRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin')]
final class AdminController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    #[Route('/index', name: 'admin_index')]
    public function index(FlightRepository $flightRepository, CityRepository $cityRepository): Response
    {
        $flights = $flightRepository->findBy([], ['departureDate' => 'asc']);
        $cities = $cityRepository->findBy([], ['name' => 'asc']);

        return $this->render('admin/index.html.twig', [
            'flights' => $flights,
            'cities' => $cities
        ]);
    }

    #[Route('/add_flight', name: 'admin_add_flight')]
    public function addFlight(Request $request): Response
    {
        $flight = new Flight();

        // Make a service.
        $range = range('A', 'Z');
        $index = array_rand($range);
        
        $flighNumber = $range[$index] . $range[$index] . rand(0,9) . rand(0,9). rand(0,9). rand(0,9);

        $form = $this->createForm(FlightType::class, $flight);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $flight->setFlightNumber($flighNumber);
        
            $this->entityManager->persist($flight);
            $this->entityManager->flush();

            $this->addFlash('success', 'Vol ajouté avec succès.');

            return $this->redirectToRoute('admin_index');
        }


        return $this->renderForm('admin/add_flight.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/edit_flight/{id}', name: 'admin_edit_flight')]
    public function editFlight(Flight $flight, Request $request): Response
    {
        $form = $this->createForm(FlightType::class,$flight);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($flight);
            $this->entityManager->flush();

            $this->addFlash('success', 'Vol modifié.');

            return $this->redirectToRoute('admin_index');
        }

        return $this->renderForm('admin/edit_flight.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/delete_flight/{id}', name: 'admin_delete_flight')]
    public function deleteFlight(Flight $flight): Response
    {
        $this->entityManager->remove($flight);
        $this->entityManager->flush();

        $this->addFlash('success', 'Vol supprimé.');

        return $this->redirectToRoute('admin_index');
    }

    #[Route('/add_city', name: 'admin_add_city')]
    public function addCity(Request $request): Response
    {
        $city = new City();

        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($city);
            $this->entityManager->flush();

            $this->addFlash('success', 'Ville ajoutée avec succès.');

            return $this->redirectToRoute('admin_index');
        }

        return $this->renderForm('admin/add_city.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/edit_city/{id}', name: 'admin_edit_city')]
    public function editCity(City $city, Request $request): Response
    {
        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($city);
            $this->entityManager->flush();

            $this->addFlash('success', 'Ville modifiée.');

            return $this->redirectToRoute('admin_index');
        }

        return $this->renderForm('admin/edit_city.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/delete_city/{id}', name: 'admin_delete_city')]
    public function deleteCity(City $city): Response
    {
        $this->entityManager->remove($city);
        $this->entityManager->flush();

        $this->addFlash('success', 'Ville supprimée');

        return $this->redirectToRoute('admin_index');
    }
}