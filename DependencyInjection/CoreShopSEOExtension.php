<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2019 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Bundle\SEOBundle\DependencyInjection;

use CoreShop\Bundle\SEOBundle\DependencyInjection\Compiler\ExtractorRegistryServicePass;
use CoreShop\Component\SEO\Extractor\ExtractorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class CoreShopSEOExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $bundles = $container->getParameter('kernel.bundles');

        if (array_key_exists('LuceneSearchBundle', $bundles)) {
            $loader->load('services/lucene_search.yml');
        }

        $container
            ->registerForAutoconfiguration(ExtractorInterface::class)
            ->addTag(ExtractorRegistryServicePass::EXTRACTOR_TAG);
    }
}
