<?php

namespace App\Controller;

use App\Entity\Reassurance;
use App\Form\ReassType;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReassuranceController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $rows = $this->getDoctrine()->getRepository(Reassurance::class)->findAll();

        return $this->render('index.html.twig', [
            'rows' => $rows,
        ]);
    }

       /**
        * @Route("/save", name="store")
     * Method({"GET", "POST"})
     */
    public function store(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $data = new Reassurance();

        $form = $this->createForm(ReassType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $img=$request->get("icone");
            $data->setIcone($img);
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('add.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/reassurance/delete/{id}", name="destroy")
        * @Method({"DELETE"})
     */
    public function destroy(Request $request, $id)
    {
        $reass = $this->getDoctrine()->getRepository(Reassurance::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reass);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('index');

    }
    /**
     *@Route("/reassurance/edit/{id}", name="edit") 
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $data = new Reassurance();
        $data = $this->getDoctrine()->getRepository(Reassurance::class)->find($id);
        $form = $this->createForm(ReassType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('edit.html.twig', ['form' => $form->createView()]);
    }


}
