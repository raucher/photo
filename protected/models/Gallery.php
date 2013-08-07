<?php

/**
 * This is the model class for table "tbl_gallery".
 *
 * The followings are the available columns in table 'tbl_gallery':
 * @property integer $id
 * @property string $_translForeignKey
 *
 * The followings are the available model relations:
 * @property Media[] $medias
 * @property GalleryTranslation[] $translations
 * @property GalleryTranslation $translation
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class Gallery extends ActiveRecordExt
{
    protected $_translForeignKey = 'gallery_id';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Gallery the static model class
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
		return 'tbl_gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id', 'safe', 'on'=>'search'),
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
			'medias' => array(self::MANY_MANY, 'Media', 'tbl_gallery_media_assoc(gallery_id, media_id)'),
			'translations' => array(self::HAS_MANY, 'GalleryTranslation', 'gallery_id'),
			'translation' => array(self::HAS_ONE, 'GalleryTranslation', 'gallery_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}