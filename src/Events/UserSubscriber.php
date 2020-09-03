<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorizations\UserAuthorizationChecker;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSubscriber implements EventSubscriberInterface
{

    // Garde fou pour les methods User qui sont utilisables uniquement si identifier

    private $methodNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET
    ];

    private $userAuthorizationChecker;


    // Utilise la classe UserAuthorizationChecker présent dans /src/Authorization

    public function __construct(UserAuthorizationChecker $userAuthorizationChecker)
    {
        $this->userAuthorizationChecker = $userAuthorizationChecker;

    }

    // Creer un event avec la function check en 1er parametre et la priorité de l'event en 2ieme
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW=>['check', EventPriorities::PRE_VALIDATE]
        ];
    }

    // Check la method
    public function check(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($user instanceof User && !in_array($method, $this->methodNotAllowed,true))
        {
            $this->userAuthorizationChecker->check($user,$method);
            $user->setUpdatedAt(new \DateTimeImmutable());
        }

    }
}