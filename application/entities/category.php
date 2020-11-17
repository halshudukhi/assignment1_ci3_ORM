<?php

class Category extends RabbitORM\Model 
{
    public $table;
    const categoryDefinition = '{"name": "Category", "table": "category"}';

    public $idCategory; 
    const idCategoryDefinition = '{"name":"idCategory", "column":"idCategory","primaryKey":"true"}';

    public $categoryName; 
    const categoryNameDefinition = '{"name":"categoryName","column":"categoryName"}';

    public $isParent;
    const isParentDefinition = '{"name": "isParent", "column":"isParent"}';

    public function children()
    {
        return $this->hasMany('Category');
    }
}