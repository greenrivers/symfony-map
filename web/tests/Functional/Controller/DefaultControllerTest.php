<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Controller\DefaultController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @covers DefaultController::index
     */
    public function testIndex(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('title', 'Greenrivers Symfony');
        self::assertSelectorExists('#root');
    }
}
