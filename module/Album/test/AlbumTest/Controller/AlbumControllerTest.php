<?php 

namespace AlbumTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AlbumControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(include '/config/application.config.php');
        parent::setUp();
    }   
    
    public function testIndexActionCanBeAccessed()
    {
        $albumTableMock = $this->getMockBuilder('Album\Model\AlbumTable')
            ->disableOriginalConstructor()
            ->getMock();
        
        $albumTableMock->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue(array()));
        
        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Album\Model\AlbumTable', $albumTableMock);
        
        $this->dispatch('/album');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Album');
        $this->assertControllerName('Album\Controller\Album');
        $this->assertControllerClass('AlbumController');
        $this->assertMatchedRouteName('album');
    }
}