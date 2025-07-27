<?php

namespace App\EventSubscriber;

use App\Entity\Service;
use App\Entity\PageContent;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Symfony\Component\Filesystem\Filesystem;

class ImageCleanupSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            Events::postUpdate => 'onPostUpdate',
        ];
    }

    public function onPostUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        $filesystem = new Filesystem();

        // Cas 1 : Service
        if ($entity instanceof Service) {
            $oldImage = $entity->getOldImage();
            if ($oldImage && $oldImage !== $entity->getImage()) {
                $path = __DIR__.'/../../public/uploads/services/'.$oldImage;
                if ($filesystem->exists($path)) {
                    $filesystem->remove($path);
                }
            }
        }

        // Cas 2 : PageContent
        if ($entity instanceof PageContent) {
            $oldImage = $entity->getOldImage();
            if ($oldImage && $oldImage !== $entity->getImage()) {
                $path = __DIR__.'/../../public/uploads/pages/'.$oldImage;
                if ($filesystem->exists($path)) {
                    $filesystem->remove($path);
                }
            }
        }
    }
}
