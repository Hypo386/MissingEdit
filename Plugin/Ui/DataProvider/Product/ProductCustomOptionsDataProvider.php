<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Ui\DataProvider\Product\ProductCustomOptionsDataProvider
    as ObservedProductCustomOptionsDataProvider;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class ProductCustomOptionsDataProvider
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product
 */
class ProductCustomOptionsDataProvider
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
     * @var Http
     */
    protected $request;

    /**
     * @var ContextInterface
     */
    protected $context;

    /**
     * ObservedProductDataProvider constructor.
     *
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param Http $request
     * @param ContextInterface $context
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Escaper $escaper,
        Http $request,
        ContextInterface $context
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->escaper    = $escaper;
        $this->request    = $request;
        $this->context    = $context;
    }

    /**
     * AfterGetData
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param ObservedProductCustomOptionsDataProvider $subject
     * @param array $data
     *
     * @return array
     */
    public function afterGetData(
        ObservedProductCustomOptionsDataProvider $subject,
        array $data
    ) {
        $requestNamespace = $this->request->getParam('namespace');
        $storeId          = $this->context->getFilterParam('store_id');

        if (!empty($data['items']) && in_array($requestNamespace, $this->getNamespaces())) {
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

    /**
     * GetNamespaces
     *
     * @return array
     */
    protected function getNamespaces()
    {
        return ['product_custom_options_listing'];
    }
}
