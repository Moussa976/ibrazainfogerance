<?php

namespace App\DataFixtures;

use App\Entity\Coordonnee;
use App\Entity\MapEmbed;
use App\Entity\PageContent;
use App\Entity\ReseauSocial;
use App\Entity\Service;
use App\Entity\Statistique;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // USERS
        $users = [
            ['contact@ibrazainfogerance.yt', ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'], '$2y$13$FlEuKVMk9zZhuR92tGGJfOgGdkWuEN/Ewh0m4SdP5DQkQrqCsLsH.'],
            ['moussainssa@outlook.fr', ['ROLE_ADMIN'], '$2y$13$29eMBBzDf7bxhrzHzNfUIuXWoFlyaaqcCzdi0tjrdxkeg8P92xCFW'],
        ];

        foreach ($users as [$email, $roles, $passwordHash]) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setPassword($passwordHash);
            $manager->persist($user);
        }

        // STATISTIQUES
        foreach ([
            ['Clients satisfaits', 150],
            ['Projets réalisés', 15],
            ['Interventions/an', 97],
        ] as [$label, $value]) {
            $stat = new Statistique();
            $stat->setLabel($label);
            $stat->setValue($value);
            $manager->persist($stat);
        }

        // COORDONNÉES
        foreach ([
            ['Adresse', 'fas fa-map-marker-alt', '<div>1456 Route départementale,<br>Mtsamboro 97630,<br>Mayotte (YT)</div>'],
            ['Téléphone', 'fas fa-phone-alt', '<ul><li>0269 06 67 08</li><li>0639 02 18 60</li></ul>'],
            ['Email', 'fas fa-envelope', '<div>contact@ibrazainfogerance.yt</div>'],
            ['Horaires', 'fas fa-clock', '<ul><li><strong>Lundi - Jeudi</strong> : 8h à 12h et 14h à 17h</li><li><strong>Vendredi</strong> : 8h à 11h30 et 13h30 à 17h</li><li><strong>Samedi</strong> : 8h - 16h</li></ul>'],
        ] as [$type, $icon, $value]) {
            $c = new Coordonnee();
            $c->setType($type);
            $c->setIcon($icon);
            $c->setValue($value);
            $manager->persist($c);
        }

        // RÉSEAUX SOCIAUX
        foreach ([
            ['Facebook', 'https://www.facebook.com/profile.php?id=100089623243573', 'fab fa-facebook-f'],
            ['Linkedin', 'https://www.linkedin.com/company/ibraza-infogerance/about/', 'fab fa-linkedin-in'],
            ['Instagram', 'https://www.instagram.com/ibraza.infogerance/', 'fab fa-instagram'],
            ['TikTok', 'https://www.tiktok.com/@ibraza.infogerance', 'fab fa-tiktok'],
        ] as [$name, $url, $icon]) {
            $r = new ReseauSocial();
            $r->setName($name);
            $r->setUrl($url);
            $r->setIcon($icon);
            $manager->persist($r);
        }

        // MAP EMBED
        $map = new MapEmbed();
        $map->setIframe('<iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>');
        $manager->persist($map);

        // PAGE CONTENT
        $pages = [
            ['accueil', 'Votre partenaire en infogérance', "Ibraza Infogérance s'occupe de votre infrastructure informatique et réseaux de A à Z durant toute l'année.", "photo-1484557052118-f32bd25b45b5-1753617091.avif"],
            ['services', 'Nos Services', 'Découvrez les prestations professionnelles proposées par Ibraza Infogérance.'],
            ['apropos', 'À propos de nous', 'Découvrez qui nous sommes, notre mission et nos engagements au service de votre performance informatique.', 'photo-1519389950473-47ba0277781c-1753615302.avif', 'Notre vision', '<div>Ibraza Infogérance (2i) est une entreprise...</div>'],
            ['nous-contacter', 'Nous contacter', "Pour toute question, information ou besoin d'assistance, vous pouvez nous joindre facilement via ce formulaire ou par nos coordonnées ci-dessous."],
            ['demande-de-devis', 'Demande de devis', 'Merci de remplir le formulaire ci-dessous pour recevoir un devis personnalisé adapté à vos besoins informatiques.'],
        ];

        foreach ($pages as $p) {
            $page = new PageContent();
            $page->setSlug($p[0]);
            $page->setTitle($p[1]);
            $page->setSubtitle($p[2]);
            $page->setImage($p[3] ?? null);
            $page->setContentTitle($p[4] ?? null);
            $page->setContent($p[5] ?? null);
            $manager->persist($page);
        }

        $manager->flush();
    }
}
