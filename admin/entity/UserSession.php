<?php
class UserSession
{
    public readonly int $id;
    public readonly string $username;
    public readonly string $name;
    public readonly ?string $urlAvatar;
    public function __construct(int $id, string $username, 
        string $name, ?string $urlAvatar) {
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
        $this->urlAvatar = $urlAvatar;
    }
}