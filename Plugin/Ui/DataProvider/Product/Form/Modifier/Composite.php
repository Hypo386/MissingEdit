<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier;

use Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\BundlePanel;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class Composite
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier
 */
class Composite
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var ContextInterface
     */
    protected $context;

    /**
     * Composite constructor.
     *
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param ContextInterface $context
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Escaper $escaper,
        ContextInterface $context
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->escaper    = $escaper;
        $this->context    = $context;
    }

    /**
     * AfterModifyData
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\Composite $subject
     * @param array $data
     *
     * @return array
     */
    public function afterModifyData(
        \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\Composite $subject,
        array $data
    ) {
        $modelId = key($data);
        $storeId = $this->context->getFilterParam('store_id');

        if (is_numeric(
            $modelId
        ) && !empty(($data[$modelId][BundlePanel::CODE_BUNDLE_OPTIONS][BundlePanel::CODE_BUNDLE_OPTIONS]))) {
            foreach ($data[$modelId][BundlePanel::CODE_BUNDLE_OPTIONS][BundlePanel::CODE_BUNDLE_OPTIONS] as
            &$bundleOption) {
                if (!empty($bundleOption['bundle_selections'])) {
                    foreach ($bundleOption['bundle_selections'] as &$bundleItem) {
                        $bundleItem['name'] = '<a href="' . $this->urlBuilder->getUrl(
                            'catalog/product/edit',
                            ['id' => $bundleItem['product_id'], 'store' => $storeId]
                        ) . '" target="_blank">' . $this->escaper->escapeHtml($bundleItem['name']) . '</a>';
                    }
                }
            }
        }

        return $data;
    }
}
