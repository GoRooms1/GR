<?php

namespace Domain\Bot\Commands;

use Telegram\Bot\Commands\Command;

/**
 * Class HelpCommand.
 */
final class HelpCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected string $name = 'help';

    /**
     * @var array Command Aliases
     */
    protected array $aliases = ['listcommands'];

    /**
     * @var string Command Description
     */
    protected string $description = 'Получить список доступных команд';

    /**
     * {@inheritdoc}
     */
    public function handle(): void
    {
        $commands = $this->telegram->getCommandBus()->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(['text' => $text]);
    }
}
