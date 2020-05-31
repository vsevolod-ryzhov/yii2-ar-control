<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


use yii\db\ActiveRecordInterface;

class ArClassesStruct
{
    /**
     * @var ActiveRecordInterface
     */
    private $baseClass;

    /**
     * @var EditableInterface
     */
    private $editableClass;

    /**
     * @var SearchableInterface
     */
    private $searchableClass;

    public function __construct(ActiveRecordInterface $baseClass)
    {
        $this->baseClass = $baseClass;
    }

    /**
     * @return EditableInterface|null
     */
    public function getEditableClass(): ?EditableInterface
    {
        return $this->editableClass;
    }

    /**
     * @param EditableInterface $editableClass
     */
    public function setEditableClass(EditableInterface $editableClass): void
    {
        $this->editableClass = $editableClass;
    }

    /**
     * @return SearchableInterface|null
     */
    public function getSearchableClass(): ?SearchableInterface
    {
        return $this->searchableClass;
    }

    /**
     * @param SearchableInterface $searchableClass
     */
    public function setSearchableClass(SearchableInterface $searchableClass): void
    {
        $this->searchableClass = $searchableClass;
    }

    /**
     * @return ActiveRecordInterface
     */
    public function getBaseClass(): ActiveRecordInterface
    {
        return $this->baseClass;
    }
}