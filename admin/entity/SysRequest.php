<?php 
class SysRequest
{
    public readonly int $status;
    public readonly string $message;
    public readonly ?object $data;
    public function __construct(int $status, string $message, ?object $data) {
        $this->status = $status;
        $this->message = $message;
        if ($data)
            $this->data = $data;
    }
}