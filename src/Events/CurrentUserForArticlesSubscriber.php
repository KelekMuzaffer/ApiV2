<?php

declare(strict_types=1);

namespace App\Events;



use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CurrentUserForArticlesSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{

    // Lier automatiquement un auteur à un article lors de la création d'un article

    /**
     * CurrentUserForArticlesSubscriber constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * function pour ajouter l'auteur à l'article
     * @param ViewEvent $event
     */
    public function currentUserForArticles(ViewEvent $event): void
    {
        $article = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($article instanceof Article && Request::METHOD_POST === $method)
        {
            $article->setAuthor($this->security->getUser());
        }
    }

    /**
     * création de l'event de la function currentUserforArticles
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW=>['currentUserForArticles', EventPriorities::PRE_VALIDATE]
        ];
    }
}