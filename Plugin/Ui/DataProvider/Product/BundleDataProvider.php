<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Bundle\Ui\DataProvider\Product\BundleDataProvider as ObservedBundleDataProvider;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class BundleDataProvider
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product
 */
class BundleDataProvider
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
     * BundleDataProvider constructor.
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
     * @param ObservedBundleDataProvider $subject
     * @param array $data
     *
     * @return array
     */
    public function afterGetData(
        ObservedBundleDataProvider $subject,
        array $data
    ) {
        $storeId = $this->context->getFilterParam('store_id');

        if (!empty($data['items'])) {
            foreach ($data['items'] as &$item) {
                $url          = $this->urlBuilder->getUrl(
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
