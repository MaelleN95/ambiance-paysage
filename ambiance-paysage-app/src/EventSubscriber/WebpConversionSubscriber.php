<?php

namespace App\EventSubscriber;

use Imagick;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WebpConversionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            Events::POST_UPLOAD => 'convertToWebp',
        ];
    }

    public function convertToWebp(Event $event): void
    {
        $object = $event->getObject();
        $mapping = $event->getMapping();

        $fileNameProperty = $mapping->getFileNamePropertyName();
        $getter = 'get' . ucfirst($fileNameProperty);
        $setter = 'set' . ucfirst($fileNameProperty);

        if (!method_exists($object, $getter)) return;

        $filename = $object->$getter();
        if (!$filename) return;

        $uploadDir = $mapping->getUploadDestination();

        $originalPath = $uploadDir . '/' . $filename;

        if (!file_exists($originalPath)) {
            return;
        }

        $imagick = new Imagick($originalPath);
        $imagick->autoOrient();
        $imagick->stripImage();
        $imagick->setImageFormat('webp');
        $imagick->setImageCompressionQuality(80);

        $newFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $newPath = $uploadDir . '/' . $newFilename;

        $imagick->writeImage($newPath);

        unlink($originalPath);

        if (method_exists($object, $setter)) {
            $object->$setter($newFilename);
        }
    }
}
