<?php
namespace App\Commands\Category;

class CreateCategoryCommand
{
    public $attribute;

    public function __construct(array $data)
    {
        $this->attribute = $data['attribute'] ?? null;
    }
}
