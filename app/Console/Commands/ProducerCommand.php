<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use function Laravel\Prompts\info as info;

final class ProducerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:producer {messages*} {--topic=}';

    /**
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        $messages = $this->argument(key: 'messages');

        $kafka = Kafka::publish()
            ->onTopic($this->option(key: 'topic'));

        foreach ($messages as $message) {
            [$key, $data] = explode(separator: ':', string: $message);

            $kafka->withMessage(
                new Message(
                    body: [$key => $data],
                    key: $key
                )
            );

            $kafka->send();
        }
    }
}
