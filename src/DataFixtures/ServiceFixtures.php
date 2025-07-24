<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $services = [
            [
                'title' => 'Infogérance & Réseaux',
                'icon' => 'fas fa-network-wired',
                'short' => 'Installation, maintenance, dépannage, administration',
                'long' => "Nous prenons en charge votre infrastructure informatique de A à Z. Cela inclut l'installation et la configuration de vos réseaux, la maintenance de vos postes de travail et serveurs, la gestion des utilisateurs, la messagerie interne et l'impression. Notre service d'infogérance vous permet de vous libérer des contraintes techniques en externalisant la gestion de votre informatique à un partenaire de confiance, tout en assurant réactivité, performance et disponibilité.",
                'image' => "https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            ],
            [
                'title' => 'Sécurité Informatique',
                'icon' => 'fas fa-shield-alt',
                'short' => 'Antivirus, anti-spam, filtrage des accès',
                'long' => "La sécurité de vos données et de votre système est une priorité absolue. Nous mettons en place des solutions globales incluant antivirus professionnels, filtrage des accès internet, politiques de mots de passe robustes, protection contre les attaques réseau (DDoS, phishing) et systèmes de surveillance en temps réel. Nos services incluent également des audits de sécurité réguliers et des conseils personnalisés pour garantir la conformité et la protection de votre environnement numérique.",
                'image' => "https://plus.unsplash.com/premium_photo-1700830452589-9d27b784f9f7?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            ],
            [
                'title' => 'Vidéosurveillance',
                'icon' => 'fas fa-video',
                'short' => 'Caméras pour entreprises et particuliers',
                'long' => "Nous proposons et installons des solutions de vidéosurveillance pour les professionnels comme pour les particuliers. Caméras IP connectées, vision à distance, enregistrement local ou cloud, alertes en temps réel... Nos systèmes sont conçus pour répondre à vos besoins spécifiques en matière de sécurité, avec une configuration sur mesure, un accompagnement technique et une maintenance adaptée à vos installations.",
                'image' => "https://plus.unsplash.com/premium_photo-1681487394066-fbc71a037573?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            ],
            [
                'title' => 'Sauvegarde & Restauration',
                'icon' => 'fas fa-database',
                'short' => 'Sauvegarde cloud et récupération rapide',
                'long' => "La perte de données peut être critique pour toute organisation. C’est pourquoi nous vous accompagnons dans la mise en place de stratégies de sauvegarde sur site et dans le cloud. Nous assurons une restauration rapide et fiable en cas d'incident, et suivons les meilleures pratiques en matière de redondance, cryptage et fréquence de sauvegarde. Nos solutions s'adaptent à vos contraintes de volumétrie, de fréquence et de criticité.",
                'image' => "https://plus.unsplash.com/premium_photo-1683141114059-aaeaf635dc05?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            ],
            [
                'title' => 'Vente de matériel',
                'icon' => 'fas fa-desktop',
                'short' => 'Ordinateurs, composants, périphériques',
                'long' => "Nous sélectionnons et fournissons du matériel informatique professionnel : ordinateurs de bureau et portables, serveurs, imprimantes, écrans, périphériques, onduleurs, etc. Nous vous conseillons selon vos besoins et votre budget, assurons la livraison, l’installation, la configuration ainsi que le support. Nous pouvons également gérer le renouvellement de votre parc informatique et vous accompagner sur la durée.",
                'image' => "https://i.postimg.cc/j2zy2363/ef237087-4838-482d-a907-07d6f49e31ff.png"
            ],
            [
                'title' => 'Mail & Communication',
                'icon' => 'fas fa-envelope',
                'short' => 'Adresses pro, domaine personnalisé, messagerie',
                'long' => "Nous mettons en place vos adresses e-mail professionnelles avec votre propre nom de domaine, pour une image plus sérieuse et sécurisée. Nos solutions incluent la gestion des boîtes mail, les outils collaboratifs, la synchronisation mobile, le webmail sécurisé et les services associés (antivirus, anti-spam, archivage). Nous assurons également la migration depuis des services existants (Gmail, Outlook, etc.) en toute sécurité.",
                'image' => "https://plus.unsplash.com/premium_photo-1721910821661-e3cd6b53b61d?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            ],
        ];

        foreach ($services as $data) {
            $service = new Service();
            $service->setTitle($data['title']);
            $service->setIcon($data['icon']);
            $service->setShortDescription($data['short']);
            $service->setLongDescription($data['long']);
            $service->setImage('https://source.unsplash.com/600x400/?network,technology');
            $manager->persist($service);
        }

        $manager->flush();
    }
}
