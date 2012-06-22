<?php

namespace Example\ExampleBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, groups={"register"}, message="このメールアドレスは既に登録されています")
 */
class User implements UserInterface
{
    const HASH_ALGORITHM  = 'sha512';
    const HASH_ITERATIONS = 5000;

    const SEX_MALE    = 1;
    const SEX_FEMALE  = 2;
    const SEX_UNKNOWN = 0;

    public static $sexTypes = array(
        self::SEX_MALE    => '男性',
        self::SEX_FEMALE  => '女性',
        self::SEX_UNKNOWN => '登録しない',
    );

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(groups={"register"})
     * @Assert\Email(groups={"register"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"register"})
     */
    protected $password;

    /**
     * @Assert\NotBlank(groups={"register"})
     */
    protected $rawPassword;

    /**
     * @ORM\Column(type="string", length=20, nullable="true")
     * @Assert\MaxLength(limit=20, groups={"register"})
     */
    protected $name;

    /**
     * @ORM\Column(type="smallint", nullable="true")
     * @Assert\Choice(choices={1, 2, 0}, groups={"register"})
     */
    protected $sex;

    /**
     * @ORM\Column(type="date", nullable="true")
     * @Assert\Date(groups={"register"})
     */
    protected $birthday;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->sex = '0';
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRawPassword()
    {
        return $this->rawPassword;
    }

    public function setRawPassword($rawPassword)
    {
        $this->rawPassword = $rawPassword;
        $this->setPassword(self::encodePassword($rawPassword, $this->getSalt()));
    }

    public function isPasswordValid($rawPassword)
    {
        $encoder = self::getEncoder();
        return $encoder->isPasswordValid($this->getPassword(), $rawPassword, $this->getSalt());
    }

    protected static function encodePassword($rawPassword, $salt)
    {
        $encoder = self::getEncoder();
        return $encoder->encodePassword($rawPassword, $salt);
    }

    protected static function getEncoder()
    {
        return new MessageDigestPasswordEncoder(self::HASH_ALGORITHM, true, self::HASH_ITERATIONS);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime $birthday = null)
    {
        $this->birthday = $birthday;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }

    public function equals(UserInterface $user)
    {
        return $user->email === $this->email;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $now = new \DateTime();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
