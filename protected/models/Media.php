<?php

/**
 * This is the model class for table "tbl_media".
 * 
 * Extends /components/ActiveRecordExt.php
 * 
 * The followings are the available columns in table 'tbl_media':
 * @property integer $id
 * @property string $src
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Gallery[] $galleries
 * @property MediaTranslation[] $translations
 * @property MediaTranslation $translation
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class Media extends ActiveRecordExt
{
    protected $_translForeignKey = 'media_id';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Media the static model class
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
		return 'tbl_media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'length', 'max'=>128),
			array('src', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, src, type', 'safe', 'on'=>'search'),
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
            'galleries' => array(self::MANY_MANY, 'Gallery', 'tbl_gallery_media_assoc(gallery_id, media_id)'),
			'translations' => array(self::HAS_MANY, 'MediaTranslation', 'media_id'),
			'translation' => array(self::HAS_ONE, 'MediaTranslation', 'media_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'src' => 'Src',
			'type' => 'Type',
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
		$criteria->compare('src',$this->src,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Checks for associated media file and deletes it if exists
	 * @return void
	 */
	protected function afterDelete()
	{
		// TODO: get paths from DB
		$catalog = realpath( Yii::app()->getBasePath().'/../media' );
		$file = $catalog."/{$this->src}";
		if( file_exists($file) ) unlink($file);
		
		parent::afterDelete();
	}

    public static function getSliderMedia()
    {
        if(($gallery = Option::getOption('slider_gallery', 'system')) === '0') // 0 means all galleries
            return Media::model()->with('translation')->findAll();

        return Gallery::model()->with(array(
            'translation'=>array(
                'select'=>false,
                'condition'=>'translation.title = :title',
                'params'=>array(':title'=>$gallery),
                'together'=>false,
            ),
            'medias'=>array(
                'with'=>'translation',
                'together'=>false,
            ),
        ))->find()->medias;
    }
}