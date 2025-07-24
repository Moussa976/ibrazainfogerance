<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{

    /**
     * @Route("/test-mail", name="test_mail")
     */
    public function testMail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('moussainssa@outlook.fr')
            ->to('moussainssa@outlook.fr')
            ->subject('Test depuis Symfony')
            ->text('Ceci est un test');

        $mailer->send($email);

        return new Response('Mail envoyé ? Vérifie ta boîte !');
    }

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
     * @Route("/devis", name="app_devis", methods={"GET", "POST"})
     */
    public function devis(Request $request, EmailService $emailService): Response
    {
        if ($request->isMethod('POST')) {
            $type = $request->request->get('type');
            $company = $request->request->get('company');
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');

            if (empty($type) || empty($name) || empty($email) || empty($subject) || empty($message)) {
                $this->addFlash('danger', 'Veuillez remplir tous les champs obligatoires.');
                return $this->redirectToRoute('app_devis');
            }

            try {
                $emailService->envoyerDevis($type, $company, $name, $email, $phone, $subject, $message);
                $this->addFlash('success', '✅ Votre demande de devis a bien été envoyée.');
            } catch (\Exception $e) {
                $this->addFlash('danger', '❌ Une erreur est survenue lors de l’envoi de votre demande.');
            }

            return $this->redirectToRoute('app_devis');
        }

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
    public function contact(Request $request, EmailService $emailService): Response
    {

        if ($request->isMethod('POST')) {

            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');

            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $this->addFlash('danger', 'Veuillez remplir tous les champs obligatoires.');
                return $this->redirectToRoute('app_contact');
            }

            try {
                // Appel du service d'envoi d'e-mail
                $emailService->envoyerContact($name, $email, $phone, $subject, $message);
                $this->addFlash('success', '✅ Votre message a bien été envoyé.');

            } catch (\Exception $e) {
                $this->addFlash('danger', '❌ Une erreur est survenue lors de l’envoi de votre message.');

            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('pages/contact.html.twig');
    }


}
