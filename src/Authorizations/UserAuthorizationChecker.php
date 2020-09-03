<?php


namespace App\Authorizations;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserAuthorizationChecker
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
    public function check(UserInterface $user, string $method): void
    {
        $this->isAuthenticated();

        if ($this->isMethodAllowed($method) && $user->getId() !== $this->user->getId())
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

    // Return true si la method est autorise
    public function isMethodAllowed(string $method): bool
    {
       return in_array($method, $this->methodAllowed, true);
    }

}