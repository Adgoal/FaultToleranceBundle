<?php

declare(strict_types=1);

namespace AdgoalCommon\FaultToleranceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     *
     * @psalm-suppress PossiblyUndefinedMethod
     * @psalm-suppress PossiblyNullReference
     *
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('adgoal_fault_tolerance');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
            ->append($this->getEnqueueConfiguration())
            ->append($this->getAlertingConfiguration())
            ->end();

        return $treeBuilder;
    }

    /**
     * Build enqueue fault tolerance config tree.
     *
     * @psalm-suppress PossiblyUndefinedMethod
     * @psalm-suppress PossiblyNullReference
     *
     * @return ArrayNodeDefinition
     */
    private function getEnqueueConfiguration(): ArrayNodeDefinition
    {
        return (new ArrayNodeDefinition('enqueue'))
            ->children()
            ->booleanNode('enabled')->defaultFalse()->end()
            ->integerNode('retryTimeout')->min(0)->defaultValue(1000000)->end()
            ->integerNode('retryAttemps')->min(0)->defaultValue(3)->end()
            ->arrayNode('clients')->normalizeKeys(false)->prototype('scalar')->end()->end()
            ->end()
            ->addDefaultsIfNotSet()
            ->canBeEnabled();
    }

    /**
     * Build alerting fault tolerance config tree.
     *
     * @psalm-suppress PossiblyUndefinedMethod
     * @psalm-suppress PossiblyNullReference
     *
     * @return ArrayNodeDefinition
     */
    private function getAlertingConfiguration(): ArrayNodeDefinition
    {
        return (new ArrayNodeDefinition('alerting'))
            ->children()
            ->booleanNode('enabled')->defaultFalse()->end()
            ->integerNode('retryTimeout')->min(0)->defaultValue(1000000)->end()
            ->integerNode('retryAttemps')->min(0)->defaultValue(3)->end()
            ->end()
            ->addDefaultsIfNotSet()
            ->canBeEnabled();
    }
}
