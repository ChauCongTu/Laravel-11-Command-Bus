<?php
namespace App\Commands\Category;

class DeleteCategoryCommand
{
    public $attribute;

    public function __construct(array $data)
    {
        $this->attribute = $data['attribute'] ?? null;
    }
}
