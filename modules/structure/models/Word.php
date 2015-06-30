<?php

namespace app\modules\structure\models;

use Yii;
use yii\caching\DbDependency;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%word}}".
 *
 * @property array $word
 * @property integer $type
 */
class Word extends ActiveRecord
{
    const ABBR = 0;
    const EXCLUSION = 1;
    const CAPITAL = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%word}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word', 'type'], 'required'],
            [['type'], 'integer'],
            [['type'], 'in', 'range'=>self::getAllowedType()],
            [['word'], 'trim'],
            [['word'], 'abbrValidate']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'word' => Yii::t('structure', 'Word'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    public function abbrValidate($attribute) {
        $allWord = self::getAllWords($this->type);
        $this->word = explode(',', preg_replace(['/\s+/', '/\s*,\s*/'], [' ', ','], $this->word));
        foreach($this->word as $word)
        {
            if(!in_array($word, $allWord))
            {
                if(!self::checkAbbrLength($word))
                    $this->addError($attribute, Yii::t('structure', '{word} is too long!', ['word'=>$word]));
            }
            else
                $this->addError($attribute, Yii::t('structure', '{word} is not unique!', ['word'=>$word]));
        }
        if($this->hasErrors($attribute))
            $this->word = implode(', ', $this->word);
    }

    /**
     * @inheritdoc
     */
    public function afterValidate() {
        if($this->isNewRecord && !$this->hasErrors())
        {
            foreach($this->word as $word)
            {
                $newWord = new Word();
                $newWord->word = $word;
                $newWord->type = $this->type;
                $newWord->save(false);
            }
        }
        return parent::afterValidate();
    }

    public function saveWords()
    {
        return $this->validate();
    }

    public static function getAllWords($type) {
         $all = self::getDb()->cache(function() use ($type){
            return self::find()->asArray()-> where('type=:type', [':type'=>$type])->all();
        },null, new DbDependency(['sql'=>'SELECT COUNT(word) FROM tbl_word WHERE type=:type', 'params'=>[':type'=>$type]]));
        $i = 0;
        return ArrayHelper::map($all, function() use (&$i) {
            return $i++;
        }, 'word');
    }

    private static function checkAbbrLength($word) {
        return mb_strlen($word, 'UTF-8') <= 255;
    }

    private static function getAllowedType()
    {
        return [self::ABBR, self::EXCLUSION, self::CAPITAL];
    }

    public static function getFileName($type) {
        switch($type) {
            case self::ABBR:
                return 'abbr';
            case self::EXCLUSION:
                return 'exclusion';
            case self::CAPITAL:
                return 'capital';
        }
    }

    public function createPhpFile($content = null) {
        if($content === null)
            $content = Word::find()->select('word')->where(['type'=>$this->type])->asArray()->all();
        if(!file_exists($path = Yii::getAlias('@structure/models/word')))
            mkdir($path, 0755, true);
        $i = 0;
        $content = ArrayHelper::map($content, function() use (&$i) {
            return $i++;
        }, 'word');
        file_put_contents($path.'/'.self::getFileName($this->type).'.php', '<?php return ' . var_export($content, true) . ';');
    }

    public static function getWords($type) {
        return file_exists(($path = Yii::getAlias('@structure/models/word/').Word::getFileName($type).'.php'))?require($path):[];
    }

    public static function getTypes() {
        return [
            self::ABBR => Yii::t('structure', 'Abbr'),
            self::EXCLUSION => Yii::t('structure', 'Exclusion'),
            self::CAPITAL => Yii::t('structure', 'Capital word'),
        ];
    }
}
