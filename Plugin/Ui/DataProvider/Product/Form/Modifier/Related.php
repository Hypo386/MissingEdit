<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related as ObservedRelated;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class Related
 *
 * @package Aos\MissingEdit\Plugin\Ui\DataProvider\Product\Form\Modifier
 */
class Related
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
     * @param ObservedRelated $subject
     * @param array $data
     *
     * @return array
     */
    public function afterModifyData(
        ObservedRelated $subject,
        array $data
    ) {
        $modelId = key($data);
        $storeId = $this->context->getFilterParam('store_id');

        foreach ($this->getDataScopes() as $dataScope) {
            if (is_numeric(
                $modelId
            ) && !empty(($data[$modelId]['links'][$dataScope]))) {
                foreach ($data[$modelId]['links'][$dataScope] as &$item) {
                    $item['name'] = '<a href="' . $this->urlBuilder->getUrl(
                        'catalog/product/edit',
                        ['id' => $item['id'], 'store' => $storeId]
                    ) . '" target="_blank">' . $this->escaper->escapeHtml($item['name']) . '</a>';
                }
            }
        }

        return $data;
    }

    /**
     * Retrieve all data scopes
     *
     * @return array
     */
    protected function getDataScopes()
    {
        return [
            ObservedRelated::DATA_SCOPE_RELATED,
            ObservedRelated::DATA_SCOPE_CROSSSELL,
            ObservedRelated::DATA_SCOPE_UPSELL,
        ];
    }

    /**
     * AfterModifyMeta
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param ObservedRelated $subject
     * @param array $meta
     *
     * @return array
     */
    public function afterModifyMeta(
        ObservedRelated $subject,
        array $meta
    ) {
        foreach ($this->getDataScopes() as $dataScope) {
            $relatedPath = $this->arrayManager->findPath($dataScope, $meta, ObservedRelated::GROUP_RELATED);
            $related     = $this->arrayManager->get($relatedPath, $meta);

            if ($related) {
                $namePath = $this->arrayManager->findPath('name', $related);
                $name     = $this->arrayManager->get($namePath, $related);

                $name['arguments']['data']['config']['elementTmpl'] =
                    'Magento_ConfigurableProduct/components/cell-html';

                $related = $this->arrayManager->remove($namePath, $related);
                $related = $this->arrayManager->set($namePath, $related, $name);

                $meta = $this->arrayManager->remove($relatedPath, $meta);
                $meta = $this->arrayManager->set($relatedPath, $meta, $related);
            }
        }

        return $meta;
    }
}
