<?php

namespace AppBundle\Service;

use Filestack\Filelink;
use Filestack\FilestackClient;
use Filestack\FilestackException;
use Filestack\FilestackSecurity;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;

class FilestackManager
{
    /** @var LoggerInterface  */
    private $logger;

    /** @var  string */
    private $apiKey;

    /** @var  string */
    private $secret;

    public function __construct(LoggerInterface $logger, $apiKey, $secret)
    {
        $this->logger = $logger;
        $this->apiKey = $apiKey;
        $this->secret = $secret;
    }

    public function upload(File $file)
    {
        $security = new FilestackSecurity($this->secret);
        $client = new FilestackClient($this->apiKey, $security);

        /** @var Filelink $filelink */
        $filelink = null;
        try {
            $filelink = $client->upload($file->getPathname());
            return $filelink->handle;
        } catch (FilestackException $e) {
            $this->logger->error("Could not upload file: ".$file->getPathname());
            $this->logger->error("Reason given: ".$e->getMessage());
            throw new \Exception('Could not upload file to Filestack');
        }
    }

    public function getFileContent($handle)
    {
        $security = new FilestackSecurity($this->secret);
        $filelink = new Filelink($handle, $this->apiKey, $security);

        try {
            return $filelink->getContent();
        } catch (FilestackException $e) {
            $this->logger->error("Could not get file with handle: ".$handle);
            $this->logger->error("Reason given: ".$e->getMessage());
            throw new \Exception('Could not get file from Filestack');
        }
    }
}
