<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use function Laravel\Prompts\info as info;

final class ConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume {topic*} {--group=}';

    /**
     * @return void
     * @throws \Carbon\Exceptions\Exception
     * @throws \Junges\Kafka\Exceptions\ConsumerException
     */
    public function handle(): void
    {
        Kafka::consumer()
            ->subscribe($this->argument(key: 'topic'))
            ->withConsumerGroupId(groupId: $this->option(key: 'group'))
            ->withHandler(function(ConsumerMessage $message) {
                $payload = json_encode($message->getBody());

                info("Key: {$message->getKey()} -> $payload");
            })
            ->build()
            ->consume();
    }
}
