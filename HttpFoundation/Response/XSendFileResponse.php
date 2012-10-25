<?php
namespace Publero\FrameworkBundle\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
class XSendFileResponse extends Response
{
    /**
     * @var string
     */
    const X_SENDFILE_HEADER_NAME = 'X-Sendfile';

    /**
     * @var string
     */
    const CONTENT_TYPE_HEADER_NAME = 'Content-Type';

    /**
     * @var string
     */
    const CONTENT_TYPE_OCTET_STREAM = 'application/octet-stream';

    /**
     * @var string
     */
    const CONTENT_DISPOSITION_HEADER_NAME = 'Content-Disposition';

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var bool
     */
    private $forceSave;

    /**
     * @param string $filePath
     * @param string|null $fileName
     * @param bool $forceSave        indicate the browser to show "Save as..." dialog instead of displaying the content
     * @throws \InvalidArgumentException
     */
    public function __construct($filePath, $fileName = null, $forceSave = false)
    {
        parent::__construct();
        $this->setFilePath($filePath);
        $this->setFileName($fileName);
        $this->setForceSave($forceSave);
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @throws \InvalidArgumentException
     */
    public function setFilePath($filePath)
    {
        if (!is_string($filePath) || empty($filePath)) {
            throw new \InvalidArgumentException("file path");
        }
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @throws \InvalidArgumentException
     */
    public function setFileName($fileName)
    {
        if (empty($fileName)) {
            $this->headers->remove(self::CONTENT_DISPOSITION_HEADER_NAME);
        } elseif (!preg_match('/^[-_a-zA-Z0-9\\.\\/]+$/', $fileName)) {
            throw new \InvalidArgumentException('file name');
        } else {
            $name = self::CONTENT_DISPOSITION_HEADER_NAME;
            $composition = sprintf('attachment; filename="%s"', $fileName);
            $this->headers->set($name, $composition, true);
        }
        $this->fileName = $fileName;
    }

    /**
     * @return bool
     */
    public function getForceSave()
    {
        return $this->forceSave;
    }

    /**
     * @param bool $forceSave    indicate the browser to show "Save as..." dialog instead of displaying the content
     */
    public function setForceSave($forceSave)
    {
        $forceSave = (bool) $forceSave;
        $mimeType = $forceSave ? self::CONTENT_TYPE_OCTET_STREAM : mime_content_type($this->getFilePath());
        $this->headers->set(self::CONTENT_TYPE_HEADER_NAME, $mimeType, true);
        $this->forceSave = $forceSave;
    }

    /**
     * Verifies the specified file and sends HTTP headers.
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws AccessDeniedHttpException
     */
    public function sendHeaders()
    {
        $realPath = realpath($this->getFilePath());
        if ($realPath === false || $this->getFilePath() === null) {
            throw new NotFoundHttpException($realPath);
        } elseif (!(is_file($realPath) && is_readable($realPath))) {
            throw new AccessDeniedHttpException($realPath);
        }
        $this->headers->set(self::X_SENDFILE_HEADER_NAME, $realPath, true);

        return parent::sendHeaders();
    }
}
