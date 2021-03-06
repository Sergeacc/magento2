<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Catalog\Test\Unit\Model\Config\CatalogClone\Media;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Catalog\Model\Config\CatalogClone\Media\Image
     */
    private $model;

    /**
     * @var \Magento\Eav\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    private $eavConfig;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $attributeCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    private $attributeCollection;

    /**
     * @var \Magento\Eav\Model\Entity\Attribute|\PHPUnit_Framework_MockObject_MockObject
     */
    private $attribute;

    protected function setUp()
    {
        $this->eavConfig = $this->getMockBuilder(\Magento\Eav\Model\Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->attributeCollection = $this->getMockBuilder(
            \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection::class
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->attributeCollectionFactory = $this->getMockBuilder(
            \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory::class
        )
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->attributeCollectionFactory->expects($this->any())->method('create')->will(
            $this->returnValue($this->attributeCollection)
        );

        $this->attribute = $this->getMockBuilder(\Magento\Eav\Model\Entity\Attribute::class)
            ->disableOriginalConstructor()
            ->getMock();

        $helper = new ObjectManager($this);
        $this->model = $helper->getObject(
            \Magento\Catalog\Model\Config\CatalogClone\Media\Image::class,
            [
                'eavConfig' => $this->eavConfig,
                'attributeCollectionFactory' => $this->attributeCollectionFactory
            ]
        );
    }

    public function testGetPrefixes()
    {
        $entityTypeId = 3;
        /** @var \Magento\Eav\Model\Entity\Type|\PHPUnit_Framework_MockObject_MockObject $entityType */
        $entityType = $this->getMockBuilder(\Magento\Eav\Model\Entity\Type::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityType->expects($this->once())->method('getId')->will($this->returnValue($entityTypeId));

        /** @var AbstractFrontend|\PHPUnit_Framework_MockObject_MockObject $frontend */
        $frontend = $this->getMockBuilder(\Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend::class)
            ->setMethods(['getLabel'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $frontend->expects($this->once())->method('getLabel')->will($this->returnValue('testLabel'));

        $this->attributeCollection->expects($this->once())->method('setEntityTypeFilter')->with(
            $this->equalTo($entityTypeId)
        );
        $this->attributeCollection->expects($this->once())->method('setFrontendInputTypeFilter')->with(
            $this->equalTo('media_image')
        );

        $this->attribute->expects($this->once())->method('getAttributeCode')->will(
            $this->returnValue('attributeCode')
        );
        $this->attribute->expects($this->once())->method('getFrontend')->will(
            $this->returnValue($frontend)
        );

        $this->attributeCollection->expects($this->any())->method('getIterator')->will(
            $this->returnValue(new \ArrayIterator([$this->attribute]))
        );

        $this->eavConfig->expects($this->any())->method('getEntityType')->with(
            $this->equalTo(Product::ENTITY)
        )->will($this->returnValue($entityType));

        $this->assertEquals([['field' => 'attributeCode_', 'label' => 'testLabel']], $this->model->getPrefixes());
    }
}
