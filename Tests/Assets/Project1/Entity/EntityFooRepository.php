<?php

declare(strict_types=1);

namespace MauticPlugin\MauticCheckBundle\Tests\Assets\Project1\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

/**
 * @extends CommonRepository<GrapesJsBuilder>
 */
class EntityFooRepository extends CommonRepository
{
    public function getTableAlias(): string
    {
        return 'foo';
    }
}
