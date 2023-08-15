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
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->keyReplacementPattern($key),
            $key . '=' . $value,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    protected function keyReplacementPattern($key)
    {
        $escaped = preg_quote('=' . $this->laravel['config']['bauth.' . $key], '/');

        return "/^{$key}{$escaped}/m";
    }
}
