<?php

namespace SoftUniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpamList
 *
 * @ORM\Table(name="spam_list")
 * @ORM\Entity(repositoryClass="SoftUniBundle\Repository\SpamListRepository")
 */
class SpamList
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
     * @ORM\Column(name="fName", type="string", length=255, nullable=true)
     */
    private $fName;

    /**
     * @var string
     *
     * @ORM\Column(name="mName", type="string", length=255, nullable=true)
     */
    private $mName;

    /**
     * @var string
     *
     * @ORM\Column(name="lName", type="string", length=255, nullable=true)
     */
    private $lName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_at", type="datetime")
     */
    private $addedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edited_at", type="datetime")
     */
    private $editedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


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
     * Set fName
     *
     * @param string $fName
     *
     * @return SpamList
     */
    public function setFName($fName)
    {
        $this->fName = $fName;

        return $this;
    }

    /**
     * Get fName
     *
     * @return string
     */
    public function getFName()
    {
        return $this->fName;
    }

    /**
     * Set mName
     *
     * @param string $mName
     *
     * @return SpamList
     */
    public function setMName($mName)
    {
        $this->mName = $mName;

        return $this;
    }

    /**
     * Get mName
     *
     * @return string
     */
    public function getMName()
    {
        return $this->mName;
    }

    /**
     * Set lName
     *
     * @param string $lName
     *
     * @return SpamList
     */
    public function setLName($lName)
    {
        $this->lName = $lName;

        return $this;
    }

    /**
     * Get lName
     *
     * @return string
     */
    public function getLName()
    {
        return $this->lName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return SpamList
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set addedAt
     *
     * @param \DateTime $addedAt
     *
     * @return SpamList
     */
    public function setAddedAt($addedAt)
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    /**
     * Get addedAt
     *
     * @return \DateTime
     */
    public function getAddedAt()
    {
        return $this->addedAt;
    }

    /**
     * Set editedAt
     *
     * @param \DateTime $editedAt
     *
     * @return SpamList
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * Get editedAt
     *
     * @return \DateTime
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return SpamList
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}

