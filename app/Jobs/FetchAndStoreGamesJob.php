<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\IgdbService;
use App\Services\LocalGameService;

class FetchAndStoreGamesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $igdbService;
    protected $localGameService;

    /**
     * Create a new job instance.
     *
     * @param IgdbService $igdbService
     * @param LocalGameService $localGameService
     */
    public function __construct(IgdbService $igdbService, LocalGameService $localGameService)
    {
        $this->igdbService = $igdbService;
        $this->localGameService = $localGameService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $games = $this->igdbService->getGames();
        $this->localGameService->storeGames($games);

        // You can log the success or send notifications as needed
        // Log::info('Game data fetched and stored successfully.');
    }
}

