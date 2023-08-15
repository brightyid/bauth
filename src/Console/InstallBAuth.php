<?php

namespace Brighty\BAuth\Console;

use Illuminate\Console\Command;

class InstallBAuth extends Command
{

    protected $signature = 'bauth:install';

    protected $description = 'Install the BAuth package';


    public function handle()
    {
        $this->info('Installing BAuth...');

        $endpoint = $this->ask('What is the BAuth endpoint? (default: http://localhost:8000/api/v1)');

        if ($endpoint) {
            $this->addEnvVariable('BAUTH_ENDPOINT', $endpoint);
        } else {
            $this->addEnvVariable('BAUTH_ENDPOINT', 'http://localhost:8000/api/v1');
        }

        $this->copyFile(__DIR__ . '/../../config/bauth.php', 'config/bauth.php');

        $this->info('Installed BAuth');
    }

    function addEnvVariable($variable, $value, $envFilePath = '.env')
    {
        $currentEnv = file_get_contents(base_path() . '/' . $envFilePath);

        $newLine = "$variable=$value";

        if (strpos($currentEnv, "$variable=") === false) {
            $newEnv = $currentEnv . "\n" . $newLine;

            file_put_contents($envFilePath, $newEnv);

            return true; // Variable added successfully
        } else {
            return false; // Variable already exists
        }
    }

    // copy file config
    function copyFile($source, $destination)
    {
        if (!file_exists($destination)) {
            copy($source, $destination);
        }
    }
}
