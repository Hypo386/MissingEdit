<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;

/**
 * Class BundlePanel
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier
 */
class BundlePanel
{
    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * BundlePanel constructor.
     *
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }

    /**
     * AfterModifyMeta
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\BundlePanel $subject
     * @param array $meta
     *
     * @return array
     */
    public function afterModifyMeta(
        \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\BundlePanel $subject,
        array $meta
    ) {
        $bundleSelectionsPath = $this->arrayManager->findPath('bundle_selections', $meta, null, 'children');
        $bundleSelections     = $this->arrayManager->get($bundleSelectionsPath, $meta);

        if ($bundleSelections) {
            $namePath = $this->arrayManager->findPath('name', $bundleSelections);
            $name     = $this->arrayManager->get($namePath, $bundleSelections);

            $name['arguments']['data']['config']['elementTmpl'] = 'Magento_ConfigurableProduct/components/cell-html';

            $bundleSelections = $this->arrayManager->remove($namePath, $bundleSelections);
            $bundleSelections = $this->arrayManager->set($namePath, $bundleSelections, $name);

            $meta = $this->arrayManager->remove($bundleSelectionsPath, $meta);
            $meta = $this->arrayManager->set($bundleSelectionsPath, $meta, $bundleSelections);
        }

        return $meta;
    }
}
