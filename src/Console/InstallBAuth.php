<?php

namespace Brighty\BAuth\Console;

use Illuminate\Console\Command;

class InstallBAuth extends Command
{

    protected $signature = 'bauth:install {--endpoint? : The BAuth endpoint}';

    protected $description = 'Install the BAuth package';


    public function handle()
    {
        $this->info('Installing BAuth...');

        if ($this->option('endpoint')) {
            $this->setEnv('BAUTH_ENDPOINT', $this->option('endpoint'));
        } else {
            $endpoint = $this->ask('What is the BAuth endpoint? (default: http://localhost:8000/api/v1)');

            if ($endpoint) {
                $this->setEnv('BAUTH_ENDPOINT', $endpoint);
            }
        }


        $this->call('vendor:publish', [
            '--provider' => "Brighty\BAuth\BAuthServiceProvider",
            '--tag' => "config",
            '--force' => true,
        ]);

        $this->info('Installed BAuth');
    }

    protected function setEnv($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }
    }
}
