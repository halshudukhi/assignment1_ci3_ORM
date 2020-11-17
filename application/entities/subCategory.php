<?php

class Subs extends RabbitORM\Model 
{
    public $table;
    const subsDefinition = '{"name": "Subs", "table": "subs"}';

    public $idSub; 
    const idSubDefinition = '{"name":"idSub", "column":"idSub", "primaryKey":"true"}';

    public $idParent; 
    const idParentDefinition = '{"name":"idParent", "column":"idParent"}';

    public $idChild; 
    const idChildDefinition = '{"name":"idChild", "column":"idChild"}';

    public $categoryName;

    public function parent()
    {
        return $this->belongsTo('Category');
    }
}