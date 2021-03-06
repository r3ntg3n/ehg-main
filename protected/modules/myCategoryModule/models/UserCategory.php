<?php

/**
 * This is the model class for table "UserCategory".
 *
 * The followings are the available columns in table 'UserCategory':
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 */
class UserCategory extends CActiveRecord
{
	public $user_login_search;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserCategory the static model class
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
		return 'UserCategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, user_id, user_login_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
			return array( 'user'=> array( self::BELONGS_TO, 'User', 'user_id' ),  );
		
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'user_id' => 'User',
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
		$criteria->with = array( 'user' );
		$criteria->compare('id',$this->id);
		
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user.login',$this->user_login_search, true);

		if(!empty($_GET['category_id'])){
			$criteria->compare('category_id',$_GET['category_id']);
		}else{
			$criteria->compare('category_id',$this->category_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
		        'attributes'=>array(
		            'user_login_search'=>array(
		                'asc'=>'user.login',
		                'desc'=>'user.login DESC',
		            ),
		            '*',
		        ),
		    ),
		));
	}
}