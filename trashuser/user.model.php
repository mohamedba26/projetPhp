<?php

class UserModel
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $address;
    private $phone;
    private $role;

    public function __construct(?int $id = null, ?string $name = null, ?int $email = null, ?int $password = null, ?string $address = null, ?int $phone = null, ?int $role = null)
    {
        if ($id != null)
            $this->id = $id;
        if ($name != null) {
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->address = $address;
            $this->role = $role;
            $this->phone = $phone;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getname()
    {
        return $this->name;
    }

    public function getemail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getaddress()
    {
        return $this->address;
    }

    public function getphone()
    {
        return $this->phone;
    }

    public function getrole()
    {
        return $this->role;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setname($name)
    {
        $this->name = $name;
    }

    public function setemail($email)
    {
        $this->email = $email;
    }

    public function setpassword($password)
    {
        $this->password = $password;
    }

    public function setaddress($address)
    {
        $this->address = $address;
    }

    public function setphone($phone)
    {
        $this->phone = $phone;
    }

    public function setrole($role)
    {
        $this->role = $role;
    }
}
