<?php
 
namespace app\models;
 
use Yii;
use yii\base\Model;
use Mailgun\Mailgun;
 
/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    const API = 'key-2308fdc2649b85c1005aafc460813834';
    const DOMAIN = "sandboxab7e76d644b145b0979bd43be6744320.mailgun.org";
    const HTML_PATH = '/../mail/htmlEmail.php';

    public $email;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }
 

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
 
        if (!$user) {
            return false;
        }
 
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $mailGunClient = new Mailgun(self::API);
        $html = $this->renderHtmlEmail(__DIR__ . self::HTML_PATH);

        $result = $mailGunClient->sendMessage(self::DOMAIN, [
            'from'      => Yii::$app->params['adminEmail'],
            'to'        => $this->email,
            'subject'   => 'Password reset for ' . $user->username,
            'html'      => $html,
        ]);

        return $result;
    }

    public function renderHtmlEmail($path)
    {
        ob_start();
        include($path);
        $htmlEmail = ob_get_contents();
        ob_end_clean();
        return $htmlEmail;
    }
}