<?php

namespace App\Controller;

use App\Entity\Reassurance;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReassuranceController extends AbstractController
{
    /**
     * @Route("/", name="reassurance")
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
     */
    public function store(): Response
    {
        return $this->render('add.html.twig', [
            'data' => '',
        ]);
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
        return $this->redirectToRoute('reassurance');

    }

}
