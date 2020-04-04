<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\GroupedProduct\Ui\DataProvider\Product\GroupedProductDataProvider as ObservedGroupedProductDataProvider;

/**
 * Class GroupedDataProvider
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product
 */
class GroupedProductDataProvider
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
     * GroupedProductDataProvider constructor.
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
     * AfterGetData
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param ObservedGroupedProductDataProvider $subject
     * @param array $data
     *
     * @return array
     */
    public function afterGetData(
        ObservedGroupedProductDataProvider $subject,
        array $data
    ) {
        $storeId = $this->context->getFilterParam('store_id');

        if (!empty($data['items'])) {
            foreach ($data['items'] as &$item) {
                $url = $this->urlBuilder->getUrl(
                    'catalog/product/edit',
                    ['id' => $item['entity_id'], 'store' => $storeId]
                );
                $item['name'] = '<a href="javascript:;" onclick="window.open(\'' . $url . '\', \'_blank\');">'
                                . $this->escaper->escapeHtml(
                                    $item['name']
                                ) . '</a>';
            }
        }

        return $data;
    }
}
