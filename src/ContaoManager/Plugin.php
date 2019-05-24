<?php

namespace SyncAccClientBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerBundle\ContaoManagerBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use MenAtWork\CtoCommunicationBundle\CtoCommunicationBundle;
use SyncAccClientBundle\SyncAccClientBundle;

/**
 * Class Plugin
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(SyncAccClientBundle::class)
                ->setLoadAfter(
                    [
                        ContaoCoreBundle::class,
                        ContaoManagerBundle::class,
                        CtoCommunicationBundle::class
                    ]
                )
                ->setReplace(
                    [
                        'syncacc',
                    ]
                ),
        ];
    }
}
