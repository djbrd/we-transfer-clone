<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SharedFile
 *
 * @ORM\Table(name="shared_file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SharedFileRepository")
 */
class SharedFile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="handle", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Please indicate which image file is to be uploaded.")
     * @Assert\Image()
     */
    private $handle;

    /**
     * @var string
     *
     * @ORM\Column(name="mimeType", type="string", length=255)
     */
    private $mimeType;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set handle
     *
     * @param string $handle
     *
     * @return SharedFile
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * Get handle
     *
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return SharedFile
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return SharedFile
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
