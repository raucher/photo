<?php
Yii::import('ext.multilang.MultiLangAR');
/**
 * This is the model class for table "tbl_gallery_translation".
 *
 * The followings are the available columns in table 'tbl_gallery_translation':
 * @property integer $gallery_id
 * @property string $lang
 * @property string $title
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Gallery $gallery
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class GalleryTranslation extends MultiLangAR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GalleryTranslation the static model class
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
		return 'tbl_gallery_translation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>256),
            // Encode title and purify description
            array('title', 'filter', 'filter'=>array('CHtml', 'encode')),
            array('description', 'filter', 'filter'=>array(new CHtmlPurifier(), 'purify')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gallery_id, lang, title, description', 'safe', 'on'=>'search'),
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
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gallery_id' => 'Gallery',
			'lang' => 'Lang',
			'title' => 'Title',
			'description' => 'Description',
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

		$criteria->compare('gallery_id',$this->gallery_id);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}