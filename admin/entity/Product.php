<?php 
class Product 
{
    public int $id;
    public string $name;
    public ?string $description;
    public ?string $material;
    public float $price_import;
    public float $price;
    public float $promotion;
    public bool $isSelling;
    public int $count;
    public int $countSold;
    public float $ratingRate;
    public int $ratingNumber;
    public DateTime $timeCreate;
    public bool $gender;
    public int $id_member;
    public array $sizes;
    public array $images;
}

class Size 
{
    public int $id;
    public string $name;
    public ?string $description;
    public int $count;
    public int $countSold;
}

class ImageProduct
{
    public int $id;
    public string $url;
    public string $rank;
    public DateTime $timeCreate;
}