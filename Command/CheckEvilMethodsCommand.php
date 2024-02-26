<?php

namespace MauticPlugin\MauticCheckBundle\Command;

use Mautic\CoreBundle\Command\ModeratedCommand;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\CoreBundle\Helper\PathsHelper;
use Mautic\PluginBundle\Model\PluginModel;
use MauticPlugin\MauticCheckBundle\Helper\FilesHelper;
use MauticPlugin\MauticCheckBundle\Service\DevilMethods;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckEvilMethodsCommand extends ModeratedCommand
{
    public function __construct(
        protected PathsHelper $pathsHelper,
        private CoreParametersHelper $coreParametersHelper,
        private DevilMethods $evilMethods,
        private PluginModel $pluginModel
    ) {
        parent::__construct($pathsHelper, $coreParametersHelper);
    }

    protected function configure()
    {
        $this
            ->setName('mautic:check:evil-methods')
            ->setDescription('Run PHPStan on Mautic')
            ->addArgument('plugin', null, 'The plugin to run PHPStan on');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (empty($input->getArgument('plugin'))) {
            throw new \InvalidArgumentException('Plugin name is required');
        }
        if (!$pluginName = $this->validate($input->getArgument('plugin'))) {
            throw new \InvalidArgumentException('Plugin not found');
        }
        $path             = $this->pathsHelper->getPluginsPath().'/'.$pluginName;
        $filesDirectories = FilesHelper::getFiles($path);
        $io               = new SymfonyStyle($input, $output);
        $io->title('Running evil methods check on '.$pluginName.' plugin');
        $io->progressStart(count($filesDirectories['files']));
        $result = [];
        foreach ($filesDirectories['files'] as $pathFile) {
            $io->progressAdvance();
            if ('php' !== pathinfo($pathFile, PATHINFO_EXTENSION)) {
                continue;
            }
            $code       = file_get_contents($pathFile);
            $tempResult = $this->evilMethods->check($code);
            if (empty($tempResult)) {
                continue;
            }
            $result[$pathFile] = $tempResult;
        }
        $io->progressFinish();
        if (empty($result)) {
            $io->success(['No evil methods found']);

            return 0;
        }

        $this->outputResult($io, $result);

        return 1;
    }

    private function outputResult(SymfonyStyle $io, array $result): void
    {
        $io->warning([
            'Evil methods found',
            'Total Files affected: '.count($result),
            'Total vulnerabilities found: '.array_sum(array_map(fn ($x) => count($x), $result)),
        ]);

        foreach ($result as $file => $evilMethods) {
            foreach ($evilMethods as $evilMethod) {
                $io->definitionList(
                    'File: '.$file.' '.$evilMethod['details']['vulnerability'],
                    ['Line'          => $evilMethod['line']],
                    ['Line Code'     => $evilMethod['lineCode']],
                    ['Name'          => $evilMethod['details']['name']],
                    ['Description'   => $evilMethod['details']['description']],
                    ['Example'       => $evilMethod['details']['example']],
                    ['Links'         => implode(', ', $evilMethod['details']['links'])],
                    ['CVE'           => $evilMethod['details']['cve']],
                    ['Vulnerability' => $evilMethod['details']['vulnerability']],
                    ['CWE'           => implode(', ', $evilMethod['details']['cwes'])],
                );
            }
        }
    }

    private function validate(string $plugin = null): ?string
    {
        if (null === $plugin) {
            return false;
        }
        $plugin  = str_replace('Bundle', '', $plugin);
        $plugins = $this->pluginModel->getRepository()->findAll();
        foreach ($plugins as $pluginItem) {
            if (str_contains($pluginItem->getBundle(), $plugin)) {
                return $pluginItem->getBundle();
            }
        }

        return false;
    }
}
