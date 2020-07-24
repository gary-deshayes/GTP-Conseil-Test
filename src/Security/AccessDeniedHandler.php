<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Classe qui permet de rediriger les personnes au bon endroit
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        if ($this->security->getUser() != null) {
            if ($this->security->getUser()->getRoles()[0] == "ROLE_ADMIN") {
                return new RedirectResponse($this->urlGenerator->generate('admin'));
            }
            if ($this->security->getUser()->getRoles()[0] == "ROLE_EMPLOYE") {
                return new RedirectResponse($this->urlGenerator->generate('employe'));
            }
        }
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
