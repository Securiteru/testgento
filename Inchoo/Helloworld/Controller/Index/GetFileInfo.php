<?php
/**
 * Created by PhpStorm.
 * User: securiter
 * Date: 25.02.2019
 * Time: 07:55
 */

namespace Inchoo\Helloworld\Controller\Index;

class GetFileInfo extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) {
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }

    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
}
