<?php
namespace Publero\FrameworkBundle\Tests\HttpFoundation\Response;

use Publero\FrameworkBundle\HttpFoundation\Response\XSendFileResponse;

class XSendFileResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XSendFileResponse
     */
    private $response;

    /**
     * @var string
     */
    private $filePath;

    protected function setUp()
    {
        $this->filePath = tempnam(sys_get_temp_dir(), 'testFile');
        $this->response = new XSendFileResponse($this->filePath);
    }

    protected function tearDown()
    {
        if (is_dir($this->filePath)) {
            rmdir($this->filePath);
        } elseif (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
        $this->filePath = null;
        $this->response = null;
    }

    public function testConstructor()
    {
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    public function testSetFilePath()
    {
        $this->assertEquals($this->filePath, $this->response->getFilePath());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFilePathNull()
    {
        $this->response->setFilePath(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFilePathEmpty()
    {
        $this->response->setFilePath('');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFilePathNotString()
    {
        $this->response->setFilePath(array());
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testSendHeadersFileNotExists()
    {
        unlink($this->filePath);
        $this->response->sendHeaders();
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testSendHeadersFileNotAccessible()
    {
        chmod($this->filePath, 0300);
        $this->response->sendHeaders();
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testSendHeadersNotFile()
    {
        unlink($this->filePath);
        mkdir($this->filePath, 0700);
        $this->response->sendHeaders();
    }

    public function testSetFileName()
    {
        $fileName = basename($this->filePath);
        $this->response->setFileName($fileName);

        $this->assertEquals($fileName, $this->response->getFileName());

        $contentDisposiotionHeader = $this->response->headers->get(XSendFileResponse::CONTENT_DISPOSITION_HEADER_NAME);
        $expectedContentDisposiotionHeader = sprintf('attachment; filename="%s"', $fileName);

        $this->assertEquals($expectedContentDisposiotionHeader, $contentDisposiotionHeader);
    }

    public function testSetFileNameEmpty()
    {
        $this->response->setFileName('');
        $contentDisposiotionHeader = $this->response->headers->get(XSendFileResponse::CONTENT_DISPOSITION_HEADER_NAME);

        $this->assertEmpty($this->response->getFileName());
        $this->assertNull($contentDisposiotionHeader);
    }

    public function testSetFileNameNull()
    {
        $this->response->setFileName(null);
        $contentDisposiotionHeader = $this->response->headers->get(XSendFileResponse::CONTENT_DISPOSITION_HEADER_NAME);

        $this->assertNull($this->response->getFileName());
        $this->assertNull($contentDisposiotionHeader);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFileNameInvalid()
    {
        $this->response->setFileName('invalid file name &');
    }

    public function testSetForceSaveTrue()
    {
        $this->response->setForceSave(true);

        $this->assertTrue($this->response->getForceSave());

        $contentTypeHeader = $this->response->headers->get(XSendFileResponse::CONTENT_TYPE_HEADER_NAME);

        $this->assertEquals(XSendFileResponse::CONTENT_TYPE_OCTET_STREAM, $contentTypeHeader);
    }

    public function testSetForceSaveFalse()
    {
        $this->response->setForceSave(false);

        $this->assertFalse($this->response->getForceSave());

        $contentTypeHeader = $this->response->headers->get(XSendFileResponse::CONTENT_TYPE_HEADER_NAME);

        $this->assertEquals(mime_content_type($this->filePath), $contentTypeHeader);
    }
}
