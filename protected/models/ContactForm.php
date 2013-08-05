<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'PhotoController'.
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $message;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, message', 'required'),
            // Encode and purify user inputs
			array('name, email, subject', 'filter', 'filter'=>array('CHtml', 'encode')),
			array('message', 'filter', 'filter'=>array(new CHtmlPurifier(), 'purify')),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode',
                  'ext.recaptcha.EReCaptchaValidator',
                  'privateKey'=>'6LfO_uMSAAAAADIsH6d7c3QRaUqlW2KZ_4fS7EQ-',
            ),
		);
	}

    public function validate()
    {
        $name='=?UTF-8?B?'.base64_encode($this->name).'?=';
        $subject='=?UTF-8?B?'.base64_encode($this->subject).'?=';
        $headers="From: {$name} <{$this->email}>\r\n".
            "Reply-To: {$this->email}\r\n".
            "MIME-Version: 1.0\r\n".
            "Content-type: text/plain; charset=UTF-8";

        //TODO: get admin email from options
        return parent::validate()
               && mail('some@mail.com', $subject, $this->message, $headers);
    }

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	/*public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}*/
}