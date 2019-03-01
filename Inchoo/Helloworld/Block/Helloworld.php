<?php
namespace Inchoo\Helloworld\Block;

class Helloworld extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;
    protected $_productCollectionFactory;
    protected $_stockRegistry;
    protected $_attributeSet;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet,
        array $data = []
    ) {
        $this->_productRepository = $productRepository;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_stockRegistry=$stockRegistry;
        $this->_attributeSet = $attributeSet;
        parent::__construct($context, $data);
    }

    public function getHelloWorldTxt()
    {
        return 'Hello world!';
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(5);
        return $collection;
    }

    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }

    public function getProductStock($id)
    {
        $stockId= $this->_stockRegistry->getStockItem($id)->getQty();

        return $stockId;
    }

    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }

    public function getAttributeSetName($product)
    {
        $attributeSetRepository = $this->_attributeSet->get($product->getAttributeSetId());
        return $attributeSetRepository->getAttributeSetName();
    }
}
