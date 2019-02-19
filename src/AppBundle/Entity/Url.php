<?php
// src/AppBundle/Entity/Url.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="url")
 */
class Url
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Url(
     *    protocols = {"http", "https"},
     *    message = "Entered value '{{ value }}' is not a valid url. Please include http/https protocols"
     * )
     */
    private $url;
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $shortened;

    /**
     * @return string
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param string $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $users;

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getShortened()
    {
        return $this->shortened;
    }

    public function setShortened($shortened)
    {
        $this->shortened = $shortened;
    }
}
