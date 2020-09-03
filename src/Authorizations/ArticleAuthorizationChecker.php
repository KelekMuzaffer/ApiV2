<?php


namespace App\Authorizations;


use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleAuthorizationChecker
{
    // On definit les méthods qui ont besoin d'une authentifiaction

    private $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE,
    ];
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    // Verifie l'authentification et la méthode
    public function check(Article $article, string $method): void
    {
        $this->isAuthenticated();

        if ($this->isMethodAllowed($method) && $article->getAuthor()->getId() !== $this->user->getId())
        {
            $errormessage = "It's not you're resource";
            throw new UnauthorizedHttpException($errormessage, $errormessage);
        }
    }

    // Verifie que le user est connecté
    public function isAuthenticated()
    {
        if (null === $this->user)
        {
            $errormessage = "You are not authenticated";
            throw new UnauthorizedHttpException($errormessage,$errormessage);
        }
    }

    // Return si la method est autorise
    public function isMethodAllowed(string $method): bool
    {
       return in_array($method, $this->methodAllowed, true);
    }

}