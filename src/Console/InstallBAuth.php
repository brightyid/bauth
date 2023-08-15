<?php

namespace Brighty\BAuth\Console;

use Illuminate\Console\Command;

class InstallBAuth extends Command
{

    protected $signature = 'bauth:install';

    protected $description = 'Install the BAuth package';


    public function handle()
    {
        $endpoint = $this->ask('[?] What is the BAuth endpoint? (default: http://localhost:8000/api/v1)', false);

        if ($endpoint !== false) {
            $this->addEnvVariable('BAUTH_ENDPOINT', $endpoint);
        } else {
            $this->addEnvVariable('BAUTH_ENDPOINT', '');
        }

        $this->copyFile(__DIR__ . '/../../config/bauth.php', 'config/bauth.php');

        $this->info("\n[+] BAuth installed successfully!");
    }

    function addEnvVariable($variable, $value, $envFilePath = '.env')
    {
        $currentEnv = file_get_contents(base_path() . '/' . $envFilePath);

        $newLine = "$variable=$value";

        if (strpos($currentEnv, "$variable=") === false) {
            $newEnv = $currentEnv . "\n\n" . $newLine;

            file_put_contents($envFilePath, $newEnv);

            return true;
        } else {
            return false;
        }
    }

    function copyFile($source, $destination)
    {
        if (file_exists(base_path($destination))) {
            $this->info('[+] File ' . $destination . ' already exists. Do you want to rewrite it?');
            $answer = $this->choice('[?] Choose an option', ['yes', 'no'], 1);

            if ($answer == 'yes' || $answer == 'y') {
                copy($source, base_path($destination));
                $this->info('[+] File ' . $destination . ' has been rewritten');
            } else {
                $this->info('[+] File ' . $destination . ' has not been rewritten');
            }
        } else {
            copy($source, base_path($destination));
            $this->info('[+] File ' . $destination . ' has been created');
        }
    }
}
