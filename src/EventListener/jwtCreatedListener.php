<?php


namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Security;

class jwtCreatedListener
{

    // Event qui permet d'ajouter des données en plus au token

    private $security;

    // Recupere le getUser de l'entité User grace a Security pour le passer à la variable globale private $user
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // Function qui permet de rajouter des données au token ici on à rajouté createdAt en plus
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $payload['createdAt'] = $this->security->getUser()->getCreatedAt();
        $event->setData($payload);
    }
}