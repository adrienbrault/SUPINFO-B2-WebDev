<?php

namespace Supinfo\WebBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Supinfo\WebBundle\Entity\User
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var string $salt
     */
    private $salt;

    /**
     * @var string $firstName
     */
    private $firstName;

    /**
     * @var string $lastName
     */
    private $lastName;

    /**
     * @var string $telephone
     */
    private $telephone;

    /**
     * @var string $function
     */
    private $function;

    /**
     * @var text $address
     */
    private $address;

    /**
     * @var Supinfo\WebBundle\Entity\Structure
     */
    private $structure;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Get telephone
     *
     * @return string $telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set function
     *
     * @param string $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
    }

    /**
     * Get function
     *
     * @return string $function
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set address
     *
     * @param text $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return text $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set structure
     *
     * @param Supinfo\WebBundle\Entity\Structure $structure
     */
    public function setStructure(\Supinfo\WebBundle\Entity\Structure $structure)
    {
        $this->structure = $structure;
    }

    /**
     * Get structure
     *
     * @return Supinfo\WebBundle\Entity\Structure $structure
     */
    public function getStructure()
    {
        return $this->structure;
    }

    public function __toString()
    {
        return $this->getUsername();
    }


    
    /*
     *  UserInterface specifics.
     */

    public function getRoles()
    {
        return array(
            'ROLE_ADMIN'
        );
    }

    public function eraseCredentials()
    {
        // TODO: Don't really know.
    }

    public function equals(UserInterface $user)
    {
        if ($user instanceof User && $user->getId() == $this->getId()) {
            return true;
        }
        
        return false;
    }



    /*
     *  PlainPassword is a transient property.
     */

    private $plainPassword;

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }



    /*
     *  Serializable.
     *
     *  Required by the Security Component.
     */

    public function serialize()
    {
        return serialize(array(
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'salt' => $this->salt,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'telephone' => $this->telephone,
            'function' => $this->function,
            'address' => $this->address,
        ));
    }

    public function unserialize($serialized)
    {
        $array = unserialize($serialized);

        $this->id = $array['id'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->salt = $array['salt'];
        $this->firstName = $array['firstName'];
        $this->lastName = $array['lastName'];
        $this->telephone = $array['telephone'];
        $this->function = $array['function'];
        $this->address = $array['address'];
    }

}