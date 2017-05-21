<?php

namespace AppBundle\Event\Model\Repository;

use AppBundle\Event\Model\SponsorTicket;
use CCMBenchmark\Ting\Repository\Metadata;
use CCMBenchmark\Ting\Repository\MetadataInitializer;
use CCMBenchmark\Ting\Repository\Repository;
use CCMBenchmark\Ting\Serializer\SerializerFactoryInterface;

class SponsorTicketRepository extends Repository implements MetadataInitializer
{
    /**
     * @inheritDoc
     */
    public static function initMetadata(SerializerFactoryInterface $serializerFactory, array $options = [])
    {
        $metadata = new Metadata($serializerFactory);

        $metadata->setEntity(SponsorTicket::class);
        $metadata->setConnectionName('main');
        $metadata->setDatabase($options['database']);
        $metadata->setTable('afup_forum_sponsors_tickets');

        $metadata
            ->addField([
                'columnName' => 'id',
                'fieldName' => 'id',
                'primary'       => true,
                'autoincrement' => true,
                'type' => 'int'
            ])
            ->addField([
                'columnName' => 'company',
                'fieldName' => 'company',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'token',
                'fieldName' => 'token',
                'type' => 'string'
            ])
            ->addField([
                'columnName' => 'max_invitations',
                'fieldName' => 'maxInvitations',
                'type' => 'int'
            ])
            ->addField([
                'columnName' => 'used_invitations',
                'fieldName' => 'usedInvitations',
                'type' => 'int'
            ])
            ->addField([
                'columnName' => 'id_forum',
                'fieldName' => 'idForum',
                'type' => 'int'
            ])
            ->addField([
                'columnName' => 'created_on',
                'fieldName' => 'createdOn',
                'type' => 'datetime'
            ])
            ->addField([
                'columnName' => 'edited_on',
                'fieldName' => 'editedOn',
                'type' => 'datetime'
            ])
            ->addField([
                'columnName' => 'creator_id',
                'fieldName' => 'creatorId',
                'type' => 'int'
            ])
        ;

        return $metadata;
    }
}
