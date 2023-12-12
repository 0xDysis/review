<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IgdbService;
use App\Services\LocalGameService;

class FetchAndStoreGames extends Command
{
    protected $signature = 'games:fetch-and-store';

    protected $description = 'Fetch game data from the IGDB API and store it in the database';

    protected $igdbService;
    protected $localGameService;

    public function __construct(IgdbService $igdbService, LocalGameService $localGameService)
    {
        parent::__construct();

        $this->igdbService = $igdbService;
        $this->localGameService = $localGameService;
    }

    public function handle()
    {
        $games = $this->igdbService->getGames();
        $this->localGameService->storeGames($games);

        $this->info('Game data fetched and stored successfully!');
    }
}
