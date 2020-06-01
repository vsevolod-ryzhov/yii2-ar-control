# Yii2 ActiveRecord Control

CRUD base for active record models

# Usage

**Example**
```php
// You have many ActiveRecord classes and you don't want to create separate CRUD for each one 
class Product extends \yii\db\ActiveRecord {}
class Page extends \yii\db\ActiveRecord {}

// Create ProductSearch and PageSearch classes (extending from original classes) which implements SearchableInterface. This classes providing functionality to view stored data
// Create ProductEdit and PageEdit classes (extending from original classes) which implements EditableInterface. This classes providing functionality to edit (create and update) data

class ProductSearch extends Product implements SearchableInterface
{
    private const ID = 'id';

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => [self::ID => SORT_ASC]],
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([self::ID => $this->{self::ID}]);
        return $dataProvider;
    }

    public static function getGridColumns($searchModel = null): array
    {
        // return data for GridView widget
        return [
            self::ID,
            'title',
            'price',
            'active'
        ];
    }

    public function getDetailViewAttributes(): array
    {
        // return data for DetailView widget
        return [
            'id',
            'title',
            'price',
            'active'
        ];
    }

    public function hasAccess(): bool
    {
        return true; // check user access here
    }
}

class ProductEdit extends Product implements EditableInterface
{
    public $file;

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $attributes = ['title', 'price', 'active', 'file'];
        $scenarios[EditableInterface::SCENARIO_INSERT] = $attributes;
        $scenarios[EditableInterface::SCENARIO_UPDATE] = $attributes;
        return $scenarios;
    }

    public function attributeTypes(): TypeCollection
    {
        $collection = new TypeCollection();
        $collection
            ->add('title', TypeText::class)
            ->add('price', TypeText::class)
            ->add('active', TypeCheckbox::class)
            ->add('file', TypeFile::class, ['multiple' => true])
        ;
        return $collection;
    }

    public static function createInsertUrl($getParams = null): ?string
    {
        return null; // create insert url or return null
    }

    public function hasAccess(): bool
    {
        return true; // check user access here
    }

    public function isAttributeSave(string $attribute): bool
    {
        $scenarios = $this->scenarios();
        return in_array($attribute, $scenarios[$this->scenario], true);
    }
}

// Create controller extending AbstractArController
class AdminController extends AbstractArController
{
    // all actions and views already included
}
```