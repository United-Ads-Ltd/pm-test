<?php

namespace App\Console\Commands;

use App\Models\APIKey;
use Illuminate\Console\Command;
use Str;

class MakeKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-key {name} {--scope=*} {--r|remove-old-key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an API key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $scopes = $this->option('scope');

        if (empty($scopes) || (!is_array($scopes))) {
            $scopes = [];
        }

        $existing = APIKey::where('name', '=', $name)->first();
        if (!is_null($existing)) {
            if (!$this->option('remove-old-key')) {
                if ($existing->isExpired()) {
                    $this->info('The existing key has already expired');
                }

                $this->error('A key with this name already exists');
                $this->error('If you want to remove it it, pass the --remove-old-key parameter');
                return;
            }

            $this->info('Removing the old key');
            $existing->deleteOrFail();
        }

        $secret = '';
        $key = APIKey::createFromName($name, $scopes, $secret);

        $this->info('Your key is: ' . $secret);
        $this->info('Store it safely, as it won\'t be shown again!');
        $this->info('Your bearer token is:');
        $this->info($key->bearerToken($secret));
        $this->info('You will use this to access the API. This has the same secrecy as the key shown before it');
    }
}
