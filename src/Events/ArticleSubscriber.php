<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorizations\ArticleAuthorizationChecker;
use App\Authorizations\UserAuthorizationChecker;
use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ArticleSubscriber implements EventSubscriberInterface
{


    // Garde fou pour les methods Article qui sont utilisables uniquement si identifier

    private $methodNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET
    ];

    private $articleAuthorizationChecker;


    // Utilise la classe ArticleAuthorizationChecker présent dans /src/Authorization

    public function __construct(ArticleAuthorizationChecker $articleAuthorizationChecker)
    {
        $this->articleAuthorizationChecker = $articleAuthorizationChecker;

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function check(ViewEvent $event): void
    {
        $article = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($article instanceof Article && !in_array($method, $this->methodNotAllowed, true)) {
            $this->articleAuthorizationChecker->check($article, $method);
            $article->setUpdatedAt(new \DateTimeImmutable());
        }
    }
}
