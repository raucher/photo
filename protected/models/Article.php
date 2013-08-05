<?php

/**
 * This is the model class for table "tbl_article".
 *
 * Extends /components/ActiveRecordExt.php
 * 
 * The followings are the available columns in table 'tbl_article':
 * @property integer $id
 * @property string $url
 *
 * The followings are the available model relations:
 * @property ArticleTranslation[] $articleTranslations
 * @property ArticleTranslation[] $translation
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class Article extends ActiveRecordExt
{
    protected $_translForeignKey = 'article_id';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
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
		return 'tbl_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		//   will receive user inputs.
		return array(
			array('url', 'length', 'max'=>256),
			array('url', 'filter', 'filter'=>'strip_tags'), // Pass value through strip_tags()
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url', 'safe', 'on'=>'search'),
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
			'articleTranslations' => array(self::HAS_MANY, 'ArticleTranslation', 'article_id'),
			'translation' => array(self::HAS_ONE, 'ArticleTranslation', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}