<?php

/**
 * This is the model class for table "{{static_pages}}".
 *
 * The followings are the available columns in table '{{static_pages}}':
 * @property string $page
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $keywords
 */
class StaticPage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StaticPage the static model class
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
		return '{{static_pages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page, title, description, content, keywords', 'required'),
			array('page, title', 'length', 'max'=>50),
			array('description, keywords', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page, title, description, content, keywords', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page' => 'Page',
			'title' => 'Title',
			'description' => 'Description',
			'content' => 'Content',
			'keywords' => 'Keywords',
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

		$criteria->compare('page',$this->page,true);

		$criteria->compare('title',$this->title,true);

		$criteria->compare('description',$this->description,true);

		$criteria->compare('content',$this->content,true);

		$criteria->compare('keywords',$this->keywords,true);

		return new CActiveDataProvider('StaticPage', array(
			'criteria'=>$criteria,
		));
	}
}