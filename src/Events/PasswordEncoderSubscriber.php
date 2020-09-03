<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{

    // Encodage du password à la création du user

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    // function qui utilise un event et qui reprend la function encodePassword
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    // function pour setPassword : encodage à la création
    public function encodePassword(ViewEvent $event): void
    {
        $user = $event->getControllerResult();

        if ($user instanceof User){
            $passHash = $this->encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passHash);
        }
    }
}