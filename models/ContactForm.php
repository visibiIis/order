<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Mailgun\Mailgun;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    const API = 'key-2308fdc2649b85c1005aafc460813834';
    const DOMAIN = "sandboxab7e76d644b145b0979bd43be6744320.mailgun.org";
    const HTML_PATH = '/../mail/htmlEmail.php';

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        
        $mailGunClient = new Mailgun(self::API);
        $html = $this->renderHtmlEmail(__DIR__ . self::HTML_PATH);

        $result = $mailGunClient->sendMessage(self::DOMAIN, [
            'from'      => Yii::$app->params['adminEmail'],
            'to'        => $this->email,
            'subject'   => 'Password reset for ' . $user->username,
            'html'      => $html,
        ]);

        return false;
    }
}
