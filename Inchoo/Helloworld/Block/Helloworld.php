<?php
namespace Inchoo\Helloworld\Block;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;

class Helloworld extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;
    protected $_productCollectionFactory;
    protected $_stockRegistry;
    protected $_attributeSet;
    protected $_optionFactory;
    protected $_options;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet,
        OptionFactory $optionFactory,

        array $data = []
    ) {
        $this->_productRepository = $productRepository;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_stockRegistry=$stockRegistry;
        $this->_attributeSet = $attributeSet;
        $this->_optionFactory = $optionFactory;
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
        $collection->setPageSize(0);
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

    public function getAllOptions()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $coll = $objectManager->create(\Magento\Catalog\Model\Product\AttributeSet\Options::class);

        $this->_options=[ ['label'=>'Select Attribute Set', 'value'=>'']];

        foreach ($coll->toOptionArray() as $d) {
                $this->_options[] = ['label' => $d['label'], 'value' => $d['value']];
        }
        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
