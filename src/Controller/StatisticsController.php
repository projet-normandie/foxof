<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatisticsController extends AbstractController
{
    #[Route('/stats', name: 'app_statistics')]
    public function index(GameRepository $gameRepository): Response
    {
        $finishedGames = $gameRepository->findFinishedGames();

        // Grouper les jeux par année
        $yearStats = [];
        foreach ($finishedGames as $game) {
            if ($game->getFinishedAt() === null) {
                continue;
            }

            $year = (int) $game->getFinishedAt()->format('Y');

            if (!isset($yearStats[$year])) {
                $yearStats[$year] = [
                    'year' => $year,
                    'total' => 0,
                    'gamesOfTheYear' => [],
                ];
            }

            $yearStats[$year]['total']++;

            if ($game->getIsGameOfTheYear()) {
                $yearStats[$year]['gamesOfTheYear'][] = $game;
            }
        }

        // Trier par année décroissante
        krsort($yearStats);

        return $this->render('statistics/index.html.twig', [
            'yearStats' => $yearStats,
        ]);
    }
}
