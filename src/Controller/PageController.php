<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{
    /**
     * @Route("/services", name="app_services")
     */
    public function services(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();
        return $this->render('pages/services.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/services/{slug}", name="app_service_show")
     */
    public function serviceShow(string $slug, ServiceRepository $serviceRepository): Response
{
    $service = $serviceRepository->findOneBy(['slug' => $slug]);

    if (!$service) {
        throw $this->createNotFoundException('Service non trouvé.');
    }

    return $this->render('pages/service_show.html.twig', [
        'service' => $service,
    ]);
}

    /**
     * @Route("/devis", name="app_devis")
     */
    public function devis(): Response
    {
        return $this->render('pages/devis.html.twig');
    }

    /**
     * @Route("/apropos", name="app_apropos")
     */
    public function apropos(): Response
    {
        return $this->render('pages/apropos.html.twig');
    }

    /**
     * @Route("/contact", name="app_contact", methods={"GET", "POST"})
     */
    public function contact(Request $request): Response
    {
        // Si le formulaire est soumis
        if ($request->isMethod('POST')) {
            // On récupère les données du formulaire
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');

            // Validation simple
            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $this->addFlash('danger', 'Veuillez remplir tous les champs obligatoires.');
                return $this->redirectToRoute('app_contact');
            }

            // TODO : envoyer un e-mail ou enregistrer en base ici

            // Message de confirmation
            $this->addFlash('success', 'Votre message concernant "' . htmlspecialchars($subject) . '" a bien été envoyé.');

            // Redirection pour éviter le renvoi de formulaire
            return $this->redirectToRoute('app_contact');
        }

        // Affichage de la page
        return $this->render('pages/contact.html.twig');
    }


}
