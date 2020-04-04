<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\GroupedProduct\Ui\DataProvider\Product\Form\Modifier\Grouped as ObservedGrouped;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;

/**
 * Class Grouped
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier
 */
class Grouped
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
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var ContextInterface
     */
    protected $context;

    /**
     * Grouped constructor.
     *
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param ArrayManager $arrayManager
     * @param ContextInterface $context
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Escaper $escaper,
        ArrayManager $arrayManager,
        ContextInterface $context
    ) {
        $this->urlBuilder   = $urlBuilder;
        $this->escaper      = $escaper;
        $this->arrayManager = $arrayManager;
        $this->context      = $context;
    }

    /**
     * AfterModifyData
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param ObservedGrouped $subject
     * @param array $data
     *
     * @return array
     */
    public function afterModifyData(
        ObservedGrouped $subject,
        array $data
    ) {
        $modelId = key($data);
        $storeId = $this->context->getFilterParam('store_id');

        if (is_numeric(
            $modelId
        ) && !empty(($data[$modelId]['links'][ObservedGrouped::LINK_TYPE]))) {
            foreach ($data[$modelId]['links'][ObservedGrouped::LINK_TYPE] as &$associatedItem) {
                $associatedItem['name'] = '<a href="' . $this->urlBuilder->getUrl(
                    'catalog/product/edit',
                    ['id' => $associatedItem['id'], 'store' => $storeId]
                ) . '" target="_blank">' . $this->escaper->escapeHtml($associatedItem['name']) . '</a>';
            }
        }

        return $data;
    }

    /**
     * AfterModifyMeta
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param ObservedGrouped $subject
     * @param array $meta
     *
     * @return array
     */
    public function afterModifyMeta(
        \Magento\GroupedProduct\Ui\DataProvider\Product\Form\Modifier\Grouped $subject,
        array $meta
    ) {
        $associatedPath = $this->arrayManager->findPath(ObservedGrouped::LINK_TYPE, $meta, null, 'children');
        $associated     = $this->arrayManager->get($associatedPath, $meta);

        if ($associated) {
            $namePath = $this->arrayManager->findPath('name', $associated);
            $name     = $this->arrayManager->get($namePath, $associated);

            $name['arguments']['data']['config']['elementTmpl'] = 'Magento_ConfigurableProduct/components/cell-html';

            $associated = $this->arrayManager->remove($namePath, $associated);
            $associated = $this->arrayManager->set($namePath, $associated, $name);

            $meta = $this->arrayManager->remove($associatedPath, $meta);
            $meta = $this->arrayManager->set($associatedPath, $meta, $associated);
        }

        return $meta;
    }
}
