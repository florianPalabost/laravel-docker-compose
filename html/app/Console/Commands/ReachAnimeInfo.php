<?php

namespace App\Console\Commands;

use App\Anime;
use App\Jobs\ImportAnime;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReachAnimeInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add to queue all the animes ids to import';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $content = $this->retrieveJson();
        $progressBar = $this->output->createProgressBar(count($content));
        $progressBar->start();
        for ($i = 0;$i < count($content); $i++)  {
            $id = strval($content[$i]['mal_id']);
            // add id to queue
            $tmpAnime = new Anime();
            $tmpAnime->anime_id = $id;
            try {
                // check if anime already exist -> delete it
                $oldAnime =DB::table('animes')->where('anime_id','=', $id)->get();
                if(count($oldAnime) > 0) {
                    Anime::destroy($oldAnime->get('id'));
                }
                $tmpAnime->saveOrFail();
                dispatch(new ImportAnime($tmpAnime));
                $progressBar->advance();
            }
            catch (\Exception $e) {
                Log::error($e);
            } catch (\Throwable $err) {
                Log::error($err);
            }
        }
        $progressBar->finish();
        $this->info('import id animes dones');
        return 0;
    }

    private function retrieveJson() {
        try {
            $json = Storage::disk('local')->get('animeMapping_full.json');
            return json_decode($json, true);
        } catch (FileNotFoundException $e) {
            Log::error($e);
            return $e;
        }
    }
}
