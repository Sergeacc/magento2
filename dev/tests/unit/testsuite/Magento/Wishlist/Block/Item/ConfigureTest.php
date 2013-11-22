<?php
/**
 * \Magento\Wishlist\Block\Item\Configure
 *
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento_Wishlist
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Wishlist\Block\Item;

class ConfigureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Wishlist\Block\Item\Configure
     */
    protected $_model;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mockRegistry;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mockCoreData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mockContext;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mockWishlistData;

    public function setUp()
    {
        $this->_mockWishlistData = $this->getMockBuilder('Magento\Wishlist\Helper\Data')
            ->disableOriginalConstructor()
            ->getMock();
        $this->_mockCoreData = $this->getMockBuilder('Magento\Core\Helper\Data')
            ->disableOriginalConstructor()
            ->getMock();
        $this->_mockContext = $this->getMockBuilder('Magento\View\Block\Template\Context')
            ->disableOriginalConstructor()
            ->getMock();
        $this->_mockRegistry = $this->getMockBuilder('Magento\Core\Model\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $this->_model = new \Magento\Wishlist\Block\Item\Configure(
            $this->_mockContext,
            $this->_mockCoreData,
            $this->_mockWishlistData,
            $this->_mockRegistry);
    }

    public function testGetProduct()
    {
        $product = 'some test product';
        $this->_mockRegistry->expects($this->once())
            ->method('registry')
            ->with($this->equalTo('product'))
            ->will($this->returnValue($product));

        $this->assertEquals($product, $this->_model->getProduct());
    }
}