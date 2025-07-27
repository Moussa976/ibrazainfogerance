<?php

namespace App\Controller;

use App\Entity\NewsletterSubscriber;
use App\Repository\NewsletterSubscriberRepository;
use App\Repository\ServiceRepository;
use App\Service\BrevoNewsletterService;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;






class PageController extends AbstractController
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @Route("/services", name="app_services")
     */
    public function services(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findBy(['isPublished' => true]);
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
            $recaptchaResponse = $request->request->get('g-recaptcha-response');

            if (empty($type) || empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
                $this->addFlash('danger', 'Veuillez remplir tous les champs obligatoires.');
                return $this->redirectToRoute('app_devis');
            }

            // ✅ Vérification reCAPTCHA
            $recaptchaCheck = $this->httpClient->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'body' => [
                    'secret' => $_ENV['RECAPTCHA_SECRET_KEY'],
                    'response' => $recaptchaResponse,
                    'remoteip' => $request->getClientIp(),
                ],
            ]);
            $recaptchaData = $recaptchaCheck->toArray();

            if (!$recaptchaData['success']) {
                $this->addFlash('danger', '❌ Veuillez valider le reCAPTCHA pour envoyer votre demande.');
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

        return $this->render('pages/devis.html.twig', [
            'site_key' => $_ENV['RECAPTCHA_SITE_KEY'],
        ]);
    }



    /**
     * @Route("/a-propos", name="app_apropos")
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
            $recaptchaResponse = $request->request->get('g-recaptcha-response');

            if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
                $this->addFlash('danger', 'Veuillez remplir tous les champs obligatoires.');
                return $this->redirectToRoute('app_contact');
            }

            // ✅ Vérification reCAPTCHA
            $recaptchaCheck = $this->httpClient->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'body' => [
                    'secret' => $_ENV['RECAPTCHA_SECRET_KEY'],
                    'response' => $recaptchaResponse,
                    'remoteip' => $request->getClientIp(),
                ],
            ]);
            $recaptchaData = $recaptchaCheck->toArray();

            if (!$recaptchaData['success']) {
                $this->addFlash('danger', '❌ Veuillez valider le reCAPTCHA pour envoyer votre message.');
                return $this->redirectToRoute('app_contact');
            }

            try {
                $emailService->envoyerContact($name, $email, $phone, $subject, $message);
                $this->addFlash('success', '✅ Votre message a bien été envoyé.');
            } catch (\Exception $e) {
                $this->addFlash('danger', '❌ Une erreur est survenue lors de l’envoi de votre message.');
            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('pages/contact.html.twig', [
            'site_key' => $_ENV['RECAPTCHA_SITE_KEY'],
        ]);
    }


    /**
     * @Route("/mentions-legales", name="app_mentions")
     */
    public function mentions(): Response
    {
        return $this->render('pages/mentions.html.twig');
    }

    /**
     * @Route("/politique-de-confidentialite", name="app_politique_confidentialite")
     */
    public function politiqueConfidentialite(): Response
    {
        return $this->render('pages/politique_confidentialite.html.twig');
    }

    /**
     * @Route("/conditions-generales", name="app_cgv")
     */
    public function cgv(): Response
    {
        return $this->render('pages/cgv.html.twig');
    }

    /**
     * @Route("/newsletter", name="app_newsletter", methods={"POST"})
     */
    public function newsletter(
        Request $request,
        BrevoNewsletterService $brevo,
        NewsletterSubscriberRepository $subscriberRepo,
        EntityManagerInterface $em
    ): Response {
        $email = $request->request->get('email');
        $token = $request->request->get('_token');

        if (!$this->isCsrfTokenValid('newsletter_form', $token)) {
            $this->addFlash('danger', '⏳ Le formulaire a expiré. Veuillez réessayer.');
            return $this->redirectToRoute('app_home');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addFlash('danger', '📛 Adresse e-mail invalide.');
            return $this->redirectToRoute('app_home');
        }

        // Vérifie si l'e-mail existe déjà
        if ($subscriberRepo->findOneBy(['email' => $email])) {
            $this->addFlash('info', 'ℹ️ Vous êtes déjà inscrit à notre newsletter.');
            return $this->redirectToRoute('app_home');
        }

        // Inscription chez Brevo
        if ($brevo->subscribe($email)) {
            // Enregistrement en BDD
            $subscriber = new NewsletterSubscriber();
            $subscriber->setEmail($email);
            $em->persist($subscriber);
            $em->flush();

            $this->addFlash('success', '✅ Merci ! Vous êtes bien inscrit à notre newsletter.');
        } else {
            $this->addFlash('danger', '❌ Une erreur est survenue. Merci de réessayer plus tard.');
        }

        return $this->redirectToRoute('app_home');
    }




}
