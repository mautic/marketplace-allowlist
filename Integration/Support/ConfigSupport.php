<?php

declare(strict_types=1);

namespace MauticPlugin\MauticCheckBundle\Integration\Support;

use Mautic\IntegrationsBundle\Integration\DefaultConfigFormTrait;
use Mautic\IntegrationsBundle\Integration\Interfaces\ConfigFormInterface;
use MauticPlugin\MauticCheckBundle\Integration\MauticCheckIntegration;

class ConfigSupport extends MauticCheckIntegration implements ConfigFormInterface
{
    use DefaultConfigFormTrait;
}
