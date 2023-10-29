<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ConfigService;
use App\Service\HistoryService;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    public const GOOGLE_MAP_ROUTE = 'google_map';
    public const WEATHER_ROUTE = 'weather';
    public const HISTORY_ROUTE = 'history';
    public const HISTORIES_ROUTE = 'histories';
    public const STATS_ROUTE = 'stats';

    #[Route('/google-map', name: self::GOOGLE_MAP_ROUTE, methods: [Request::METHOD_GET])]
    public function googleMap(ConfigService $configService): JsonResponse
    {
        $googleMapApiKey = $configService->getGoogleMapApiKey();
        return $this->json($googleMapApiKey);
    }

    #[Route('/weather', name: self::WEATHER_ROUTE, methods: [Request::METHOD_GET])]
    public function weather(Request $request, WeatherService $weatherService): JsonResponse
    {
        $params = $request->query->all();

        $weatherData = $weatherService->getWeatherData($params);
        return $this->json($weatherData);
    }

    #[Route('/history', name: self::HISTORY_ROUTE, methods: [Request::METHOD_POST])]
    public function history(Request $request, HistoryService $historyService): JsonResponse
    {
        $body = $request->getContent();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        $historyService->saveHistory($data);
        return $this->json(['status' => Response::HTTP_OK]);
    }

    #[Route('/histories', name: self::HISTORIES_ROUTE, methods: [Request::METHOD_GET])]
    public function histories(HistoryService $historyService): JsonResponse
    {
        $histories = $historyService->getHistories();
        return $this->json($histories);
    }

    #[Route('/stats', name: self::STATS_ROUTE, methods: [Request::METHOD_GET])]
    public function stats(HistoryService $historyService): JsonResponse
    {
        $stats = $historyService->getStats();
        return $this->json($stats);
    }
}
