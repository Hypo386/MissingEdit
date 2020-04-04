<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Listing\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class AddUrlToName
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Listing\Modifier
 */
class AddUrlToName extends AbstractModifier
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
     * AddUrlToName constructor.
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
     * ModifyData
     *
     * @param array $data
     *
     * @return array
     */
    public function modifyData(array $data)
    {
        $requestNamespace = $this->request->getParam('namespace');
        $storeId          = $this->context->getFilterParam('store_id');

        if (isset($data['items']) && in_array($requestNamespace, $this->getNamespaces())) {
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
     * ModifyMeta
     *
     * @param array $meta
     *
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    /**
     * GetNamespaces
     *
     * @return array
     */
    protected function getNamespaces()
    {
        return ['configurable_associated_product_listing'];
    }
}
