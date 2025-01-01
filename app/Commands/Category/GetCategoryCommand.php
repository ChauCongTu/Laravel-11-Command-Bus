<?php
namespace App\Commands\Category;

class GetCategoryCommand
{
    public $attribute;

    public function __construct(array $data)
    {
        $this->attribute = $data['attribute'] ?? null;
    }
}
