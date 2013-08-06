<?php
Yii::import('ext.multilang.MultiLangAR');
/**
 * This is the model class for table "tbl_article_translation".
 *
 * The followings are the available columns in table 'tbl_article_translation':
 * @property integer $article_id
 * @property string $lang
 * @property string $title
 * @property string $content
 *
 * The followings are the available model relations:
 * @property Article $article
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class ArticleTranslation extends MultiLangAR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArticleTranslation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_article_translation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
            // Encode title and purify content
			array('title', 'filter', 'filter'=>array('CHtml', 'encode')),
			array('content', 'filter', 'filter'=>array(new CHtmlPurifier(), 'purify')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('article_id, lang, title, content', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'article' => array(self::BELONGS_TO, 'Article', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_id' => 'Article',
			'lang' => 'Lang',
			'title' => 'Title',
			'content' => 'Content',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}