<?php

namespace App\Controller\Front;

use App\Entity\Meal;
use App\Form\MealType;
use App\Repository\MealRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
<<<<<<< HEAD
 * @Route("/meal", name="front_meal_")
 * @Security("is_granted('ROLE_USER')")
 */
class MealController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(MealRepository $mealRepository): Response
    {
        return $this->render('front/meal/index.html.twig', [
            'meals' => $mealRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $form->get('pictures')->getData();
            foreach ($pictures as $file){
                $path = $file->getPath();
                $fileName = md5(uniqid()).'.'.$path->guessExtension();
                $path->move(
                    'images/meal/',
                    $fileName
                );
                $file->setPath( '/images/meal/'. $fileName);
            }
            $meal->setHost($this->getUser());

            foreach ($form->getData()->getPictures() as $key => $picture){
                $picture->setMeal($meal);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meal);
            $entityManager->flush();

            return $this->redirectToRoute('front_meal_index');
        }


        return $this->render('front/meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Meal $meal): Response
    {
        return $this->render('front/meal/show.html.twig', [
            'meal' => $meal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meal $meal): Response
    {
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_meal_index', [
                'id' => $meal->getId(),
            ]);
        }

        return $this->render('front/meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Meal $meal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_meal_index');
    }
}
