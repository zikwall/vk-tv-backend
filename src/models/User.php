<?php


namespace vktv\models;

use Yii;
use yii\base\InvalidCallException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\Application as WebApplication;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use vktv\helpers\Password;
use vktv\models\query\UserFind;
use zikwall\vktv\ModuleTrait;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property int|null $confirmed_at
 * @property int|null $blocked_at
 * @property string|null $registration_ip
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $destroyed_at
 * @property int $is_destroy
 * @property string $first_device_id
 * @property int|null $is_premium
 * @property int|null $premium_ttl
 * @property int|null $is_official
 *
 * @property Friendship[] $friendships
 * @property Friendship[] $friendships0
 * @property User[] $users
 * @property User[] $friendUsers
 * @property Profile $profile
 */
class User extends ActiveRecord implements IdentityInterface
{
    use ModuleTrait;

    const BEFORE_CREATE   = 'beforeCreate';
    const AFTER_CREATE    = 'afterCreate';
    const BEFORE_REGISTER = 'beforeRegister';
    const AFTER_REGISTER  = 'afterRegister';

    // following constants are used on secured email changing process
    const OLD_EMAIL_CONFIRMED = 0b1;
    const NEW_EMAIL_CONFIRMED = 0b10;
    const SCENARIO_CHANNELS = 'SCENARIO_CHANNELS';
    const SCENARIO_GENERAL = 'SCENARIO_GENERAL';

    /**
     * @var string Plain password. Used for model validation.
     */
    public $password;

    /**
     * @var Profile|null
     */
    private $_profile;

    /**
     * @var string Default username regexp
     */
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';
    
    /**
     * @return UserFind|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserFind(get_called_class());
    }

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function attributeLabels()
    {
        return [
            'username'          => 'Username',
            'email'             => 'Email',
            'registration_ip'   => 'Registration ip',
            'unconfirmed_email' => 'New email',
            'password'          => 'Password',
            'created_at'        => 'Registration time',
            'confirmed_at'      => 'Confirmation time',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANNELS] = ['formChannels'];

        return ArrayHelper::merge($scenarios, [
            'register' => ['username', 'email', 'password'],
            'connect'  => ['username', 'email'],
            'create'   => ['username', 'email', 'password'],
            'update'   => ['username', 'email', 'password'],
            'settings' => ['username', 'email', 'password'],
        ]);
    }

    public function rules()
    {
        return [
            // username rules
            'usernameRequired' => ['username', 'required', 'on' => ['register', 'create', 'connect', 'update']],
            'usernameMatch'    => ['username', 'match', 'pattern' => static::$usernameRegexp],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernameUnique'   => ['username', 'unique', 'message' => 'This username has already been taken'],
            'usernameTrim'     => ['username', 'trim'],
            // email rules
            'emailRequired' => ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'emailPattern'  => ['email', 'email'],
            'emailLength'   => ['email', 'string', 'max' => 255],
            'emailUnique'   => ['email', 'unique', 'message' => 'This email address has already been taken'],
            'emailTrim'     => ['email', 'trim'],
            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register']],
            'passwordLength'   => ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],
        ];
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @param $token
     * @param $type
     */
    public static function loginByAccessToken($token, $type)
    {
        self::findIdentityByAccessToken($token, $type);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }
    
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    
    public static function findByEmailOrUsername($email, $username)
    {
        return static::findOne(['email' => $email, 'username' => $username]);
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->getAttribute('auth_key') === $authKey;
    }
    
    public function isBlocked() : bool
    {
        return $this->blocked_at !== null;
    }
    
    public function isDestroyed() : bool
    {
        return $this->is_destroy === 1 && $this->destroyed_at !== null;
    }
    
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }
    
    public function setProfile(Profile $profile)
    {
        $this->_profile = $profile;
    }

    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getAuthKey()
    {
        return $this->getAttribute('auth_key');
    }
    
    public function create() : bool
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = time();
        $this->password = $this->password == null ? Password::generate(8) : $this->password;

        $this->trigger(self::BEFORE_CREATE);

        if (!$this->save()) {
            return false;
        }

        // sendWelcomeMessage($this, $token);

        $this->trigger(self::AFTER_CREATE);
        return true;
    }
    
    public function register() : bool
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = null;
        $this->password     = $this->getModule()->enableGeneratingPassword ? Password::generate(8) : $this->password;

        $ip = Yii::$app->request->getUserIP();

        if ($ip !== null) {
            $this->registration_ip = $ip;
        }

        $this->trigger(self::BEFORE_REGISTER);

        if (!$this->save()) {
            return false;
        }

        if ($this->getModule()->enableConfirmation) {
            // confirm
        }

        //if(!InviteCode::invite($this)) {
        // invite
        //}

        // sendWelcomeMessage($this, $token);

        $this->trigger(self::AFTER_REGISTER);
        return true;
    }
    
    public function confirm() : bool
    {
        return (bool)$this->updateAttributes(['confirmed_at' => time()]);
    }
    
    public function resetPassword($password) : bool
    {
        return (bool)$this->updateAttributes(['password_hash' => Password::hash($password)]);
    }

    /**
     * Blocks the user by setting 'blocked_at' field to current time and regenerates auth_key.
     */
    public function block() : bool
    {
        return (bool)$this->updateAttributes([
            'blocked_at' => time(),
            'auth_key'   => Yii::$app->security->generateRandomString(),
        ]);
    }

    /**
     * UnBlocks the user by setting 'blocked_at' field to null.
     */
    public function unblock() : bool
    {
        return (bool)$this->updateAttributes(['blocked_at' => null]);
    }

    /**
     * @return bool
     */
    public function destroy() : bool
    {
        return (bool)$this->updateAttributes([
            'destroyed_at' => time(),
            'is_destroy' => 1,
        ]);
    }

    /**
     * @return bool
     */
    public function undestroy() : bool
    {
        return (bool)$this->updateAttributes([
            'destroyed_at' => null,
            'is_destroy' => 0,
        ]);
    }

    public function makePremium($ttl) : bool
    {
        $this->is_premium = 1;
        $this->premium_ttl = $ttl;
        $affectedRows = $this->updateAttributes(['is_premium', 'premium_ttl']);
        
        return $affectedRows > 0;
    }
    
    public function isAlreadyConfirmed() : bool
    {
        return $this->confirmed_at !== null;
    }

    public function afterRegistrationHandle($name, $publicEmail)
    {
        if (empty($name) && empty($publicEmail)) {
            return false;
        }

        $profile = Profile::find()->where([
            'user_id' => $this->id
        ])->one();

        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $this->id;
        }

        if (!empty($name)) {
            $profile->name = $name;
        }
        
        if (!empty($publicEmail)) {
            $profile->public_email = $publicEmail;
        }

        if (!$profile->save()) {
            return false;
        }

        return $this->confirm();
    }
    
    public function generateUsername()
    {
        // try to use name part of email
        $this->username = explode('@', $this->email)[0];
        if ($this->validate(['username'])) {
            return $this->username;
        }
        // generate username like "user1", "user2", etc...
        while (!$this->validate(['username'])) {
            $row = (new Query())
                ->from('{{%user}}')
                ->select('MAX(id) as id')
                ->one();
            $this->username = 'user' . ++$row['id'];
        }
        return $this->username;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', Yii::$app->security->generateRandomString());
            if (Yii::$app instanceof WebApplication) {
                $this->setAttribute('registration_ip', Yii::$app->request->userIP);
            }
        }
        
        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Password::hash($this->password));
        }
        
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            if ($this->_profile == null) {
                $this->_profile = Yii::createObject(Profile::className());
            }

            $this->_profile->link('user', $this);
        }
    }
}
