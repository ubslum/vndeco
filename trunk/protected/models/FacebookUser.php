<?php

/**
 * This is the model class for table "{{facebook_users}}".
 *
 * The followings are the available columns in table '{{facebook_users}}':
 * @property integer $id_facebook
 * @property integer $id_user
 * @property string $name
 * @property string $email
 * @property string $access_token
 *
 * The followings are the available model relations:
 * @property Accounts $idUser
 */
class FacebookUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FacebookUser the static model class
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
		return '{{facebook_users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_facebook, name, email, access_token', 'required'),
			array('id_facebook, id_user', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('email', 'length', 'max'=>256),
			array('access_token', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_facebook, id_user, name, email, access_token', 'safe', 'on'=>'search'),
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
			'idUser' => array(self::BELONGS_TO, 'Accounts', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_facebook' => 'Id Facebook',
			'id_user' => 'Id User',
			'name' => 'Name',
			'email' => 'Email',
			'access_token' => 'Access Token',
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

		$criteria->compare('id_facebook',$this->id_facebook);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('access_token',$this->access_token,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}