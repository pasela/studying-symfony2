<?php

namespace Example\ExampleBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class User
{
    /**
     * @Assert\NotBlank(groups={"register"})
     * @Assert\Email(groups={"register"})
     */
    protected $email;

    /**
     * @Assert\NotBlank(groups={"register"})
     */
    protected $password;

    /**
     * @Assert\NotBlank(groups={"register"})
     */
    protected $password_confirm;

    /**
     * @Assert\MaxLength(limit=20, groups={"register"})
     */
    protected $name;

    /**
     * @Assert\Choice(choices={1, 2, 0}, groups={"register"})
     */
    protected $sex;

    /**
     * @Assert\Date(groups={"register"})
     */
    protected $birthday;

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

    public function getPasswordConfirm()
    {
        return $this->password_confirm;
    }

    public function setPasswordConfirm($password_confirm)
    {
        $this->password_confirm = $password_confirm;
    }

    /**
     * @Assert\True(message="パスワードが一致しません", groups={"register"})
     */
    public function isPasswordEquals()
    {
        return $this->password === $this->password_confirm;
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
}
