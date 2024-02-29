<?php 
class Member {
    public int $id;
    public string $username;
    public ?string $password_hash;
    public bool $isOnline;
    public bool $isLock;
    public bool $isAdmin;
    public bool $isPersonnel;
    public DateTime $dateCreate;
    public string $fullName;
    public string $email;
    public string $phoneNumber;
    public bool $gender;
    public DateTime $dateOfBirth;
    public string $address;
    public string $soCCCD;
    public ?string $urlAvatar;
}