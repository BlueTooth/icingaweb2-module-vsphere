<?php

namespace Icinga\Module\Vsphere\ManagedObject;

use SoapVar;

class VirtualMachine extends ManagedObject
{
    public static function getDefaultPropertySet()
    {
        return array(
            'name',
            'parent',
            'guest.hostName',
            'guest.ipAddress',
            'guest.net',
            'guest.guestId',
            'guest.guestFullName',
            'guest.guestState',
            'guest.toolsRunningStatus',
            'runtime.bootTime',
            'runtime.host',
            'runtime.powerState',
            'config.annotation',
            'config.hardware.numCPU',
            'config.hardware.memoryMB',
            'config.template',
            'config.version',
            'config.uuid',
            // 'configStatus',
            // 'overallStatus',
        );
    }

    public static function getType()
    {
        return 'VirtualMachine';
    }

    public static function objectSet($base)
    {
        return array(
            'obj'   => $base,
            'skip'  => false,
            'selectSet' => array(
                static::traverseFolder(),
                static::traverseDatacenter(),
            ),
        );
    }

    public static function traverseFolder()
    {
        $folderTraversalSpec = array(
            'name' => 'TraverseFolder',
            'type' => 'Folder',
            'path' => 'childEntity',
            'skip' => false,
            TraversalHelper::makeSelectionSet('TraverseFolder'),
            TraversalHelper::makeSelectionSet('TraverseDatacenter')
        );

        return new SoapVar($folderTraversalSpec, SOAP_ENC_OBJECT, 'TraversalSpec');
    }

    public static function traverseDatacenter()
    {
        $traversalSpec = array(
            'name' => 'TraverseDatacenter',
            'type' => 'Datacenter',
            'path' => 'vmFolder',
            'skip' => false,
            TraversalHelper::makeSelectionSet('TraverseFolder')
        );

        return new SoapVar($traversalSpec, SOAP_ENC_OBJECT, 'TraversalSpec');
    }
}
