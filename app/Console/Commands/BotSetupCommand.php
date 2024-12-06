<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BotSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:bot-setting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the Telegram bot and webhook automatically by triggering other commands';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->info('Starting bot setup process...');

        // Fetch bot token and webhook URL from the environment
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $webhookUrl = env('TELEGRAM_WEBHOOK_URL');

        // Check if bot token and webhook URL are set
        if (empty($botToken)) {
            $this->error('Please make sure TELEGRAM_BOT_TOKEN is set in your .env file.');
            return 1;
        }

        if (empty($webhookUrl)) {
            $this->error('Please make sure TELEGRAM_WEBHOOK_URL is set in your .env file.');
            return 1;
        }

        // Step 1: Call the 'telegraph:new-bot' command interactively
        // $this->info('Creating new bot...');
        $this->runInteractiveCommand('telegraph:new-bot', [
            $botToken,
            '',
            'no',
            $webhookUrl
        ]);

        // Step 2: Call 'telegraph:set-webhook' to set the webhook for the bot

        $this->runInteractiveCommand('telegraph:set-webhook', [
            $webhookUrl
        ]);

        // Display success message
        $this->info('Bot created and webhook set successfully.');

        return 0;
    }

    /**
     * Run an interactive command and simulate user inputs.
     *
     * @param string $command
     * @param array $inputs
     * @return void
     */
    private function runInteractiveCommand(string $command, array $inputs)
    {
        // Create a new process for the Artisan command
        $process = new Process(['php', 'artisan', $command]);

        // Set up the process to simulate interactive user input
        $process->setTimeout(null);
        $process->setInput(implode("\n", $inputs) . "\n");

        // Run the process and check for success
        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            $this->error('Command failed: ' . $exception->getMessage());
        }
    }
}
