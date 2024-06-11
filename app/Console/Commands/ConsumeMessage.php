<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use function Laravel\Prompts\info as info;

final class ConsumeMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume';

    /**
     * @return void
     * @throws \Carbon\Exceptions\Exception
     * @throws \Junges\Kafka\Exceptions\ConsumerException
     */
    public function handle(): void
    {
        Kafka::consumer()
            ->subscribe('logistic')
            ->withConsumerGroupId(groupId: 'logistic')
            ->withHandler(function(ConsumerMessage $message) {
                $payload = json_encode($message->getBody());

                info("Key: {$message->getMessageIdentifier()} | Topic: {$message->getTopicName()} | Data: {$payload}");
            })
            ->build()
            ->consume();
    }
}
