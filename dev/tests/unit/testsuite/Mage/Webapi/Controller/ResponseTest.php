<?php
/**
 * Test for Webapi Response model.
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
 * @copyright   Copyright (c) 2012 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Mage_Webapi_Controller_ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * Response object.
     *
     * @var Mage_Webapi_Controller_Response
     */
    protected $_response;

    protected function setUp()
    {
        /** Initialize SUT. */
        $this->_response = new Mage_Webapi_Controller_Response();
        parent::setUp();
    }

    protected function tearDown()
    {
        unset($this->_response);
        parent::tearDown();
    }

    /**
     * Test setMimeType method.
     */
    public function testSetMimeType()
    {
        $this->markTestIncomplete('Fix test to work with output_buffering option.');
        $expectedHeader = array(
            array(
                'name' => 'Content-Type',
                'value' => 'application/xml; charset=' . Mage_Webapi_Controller_Response::RESPONSE_CHARSET,
                'replace' => true,
            ),
        );
        $actualHeader = $this->_response->setMimeType('application/xml')->getHeaders();
        /** Assert headers are equal */
        $this->assertEquals($expectedHeader, $actualHeader, 'Mime type is not set.');
    }

    /**
     * Test addMessage, hasMessage, getMessage and clearMessages methods.
     */
    public function testMessagesCrud()
    {
        /** Test new object does not contain any messages. */
        $this->assertFalse($this->_response->hasMessages(), 'New object contains messages.');

        /** Test message adding functionality. */
        $this->_response->addMessage(
            'Message text',
            200,
            array('key' => 'value'),
            Mage_Webapi_Controller_Response::MESSAGE_TYPE_SUCCESS
        );
        $this->assertTrue($this->_response->hasMessages(), 'New message is not added right.');

        /** Test message getting functionality. */
        $expectedMessage = array(
            Mage_Webapi_Controller_Response::MESSAGE_TYPE_SUCCESS => array(
                array('key' => 'value', 'message' => 'Message text', 'code' => 200)
            )
        );
        $this->assertEquals($expectedMessage, $this->_response->getMessages(), 'Message is got wrong.');

        /** Test message clearing functionality. */
        $this->_response->clearMessages();
        $this->assertFalse($this->_response->hasMessages(), 'Message is not cleared.');
    }
}
