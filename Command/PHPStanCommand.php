<?php

namespace MauticPlugin\MauticCheckBundle\Command;

use Mautic\CoreBundle\Command\ModeratedCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PHPStanCommand extends ModeratedCommand
{
    protected function configure(): void
    {
        $this
            ->setName('mautic:check:phpstan')
            ->setDescription('Run PHPStan on Mautic')
            ->addArgument('plugin', null, 'The plugin to run PHPStan on', 'GrapesJsBuilderBundle');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>PHPStan on Mautic starting...</comment>');
        $arguments = $input->getArguments();
        $output->writeln('<comment>Validate plugin...</comment>');
        $plugin = $this->validate($arguments);
        if (!$plugin) {
            $output->writeln('<error>Invalid plugin</error>');

            return \Symfony\Component\Console\Command\Command::FAILURE;
        }
        $output->writeln('<comment>Run phpStan...</comment>');
        $outputResult = $this->runPHPStan($plugin);
        if ($this->check($outputResult)) {
            $output->writeln('<info>PHPStan no errors found in '.$plugin.'</info>');

            return \Symfony\Component\Console\Command\Command::SUCCESS;
        }
        $output->writeln('<error>PHPStan errors found in '.$plugin.'</error>');

        return \Symfony\Component\Console\Command\Command::FAILURE;
    }

    private function runPHPStan(string $plugin): array
    {
        exec("[ ! -f var/cache/test/AppKernelTestDebugContainer.xml ] && (echo 'Building test cache ...'; APP_ENV=test APP_DEBUG=1 bin/console > /dev/null 2>&1);  php -d memory_limit=4G bin/phpstan analyse --ansi plugins/".$plugin, $output);

        return $output;
    }

    private function check(array $output): bool
    {
        if (count($output) > 4 && str_contains($output[2], '[OK] No errors')) {
            return true;
        }

        return false;
    }

    private function validate(array $arguments): ?string
    {
        return $arguments['plugin'];
    }
}
