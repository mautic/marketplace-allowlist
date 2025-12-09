<?php

declare(strict_types=1);

namespace MauticPlugin\MauticCheckBundle\Tests\Assets\Project1\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\EmailBundle\Entity\Email;

class EntityFoo
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Email|null
     */
    protected $email;

    public static function loadMetadata(ORM\ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable('bundle_foo')
            ->setCustomRepositoryClass(EntityFooRepository::class)
            ->addId();

        $builder->createManyToOne(
            'email',
            \Mautic\EmailBundle\Entity\Email::class
        )->addJoinColumn('email_id', 'id', true, false, 'CASCADE')->build();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return $this
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;

        return $this;
    }
}
