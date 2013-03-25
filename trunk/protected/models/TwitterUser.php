<?php

/**
 * This is the model class for table "{{twitter_users}}".
 *
 * The followings are the available columns in table '{{twitter_users}}':
 * @property integer $id_user
 * @property integer $id_twitter
 * @property string $oauth_token
 * @property string $oauth_token_secret
 * @property string $screen_name
 */
class TwitterUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TwitterUser the static model class
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
		return '{{twitter_users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_twitter, oauth_token, oauth_token_secret, screen_name', 'required'),
			array('id_user, id_twitter', 'numerical', 'integerOnly'=>true),
			array('oauth_token, oauth_token_secret, screen_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_user, id_twitter, oauth_token, oauth_token_secret, screen_name', 'safe', 'on'=>'search'),
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
			'id_user' => 'Id User',
			'id_twitter' => 'Id Twitter',
			'oauth_token' => 'Oauth Token',
			'oauth_token_secret' => 'Oauth Token Secret',
			'screen_name' => 'Screen Name',
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

		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_twitter',$this->id_twitter);
		$criteria->compare('oauth_token',$this->oauth_token,true);
		$criteria->compare('oauth_token_secret',$this->oauth_token_secret,true);
		$criteria->compare('screen_name',$this->screen_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}