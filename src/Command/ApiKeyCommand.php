<?php


namespace Mohist\SodionAuthFlarum\Command;


use Flarum\Console\AbstractCommand;
use Flarum\Settings\SettingsRepositoryInterface;

class ApiKeyCommand extends AbstractCommand
{

    protected function configure()
    {
        $this
            ->setName('sodionauth:key')
            ->setDescription('Generate a key for sodion-api');
    }
    protected function fire()
    {
        $settings = app()->make(SettingsRepositoryInterface::class);
        $key = md5(microtime()."sodionAuth");
        $settings->set('sodion_api_key',$key);
        $this->output->writeln($key);
    }
}
