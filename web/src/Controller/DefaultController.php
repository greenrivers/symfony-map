<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public const DEFAULT_ROUTE = 'default';

    #[Route(['/{_locale}/{reactRouting}', '/{reactRouting}'],
        name: self::DEFAULT_ROUTE,
        requirements: ['reactRouting' => '^(?!api).+'],
        defaults: ['reactRouting' => null],
        priority: -1
    )]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
}
