<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class Connecter
{
    public function tokenExists(SessionInterface $session): bool
    {
        // Vérifie si le token existe dans le cache
        if ($session->get("token") <> "") {
            return true;
        }

        return false;
    }
}