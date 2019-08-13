<?php declare(strict_types=1);

namespace Tests\Surda\Forms\Rendering;

use Surda\Forms\Rendering\Bs4HorizontalFormRenderer;
use Surda\Forms\Rendering\Bs4VerticalFormRenderer;
use Nette\Forms\Form;
use Nette\Forms\IFormRenderer;
use Nette\Utils\Html;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class Bs4FormRendererTest extends TestCase
{
    public function testHorizontal()
    {
        $renderer = new Bs4HorizontalFormRenderer();
        $form = $this->createFormWithRenderer($renderer);

        Assert::matchFile(__DIR__ . '/Bs4FormRendererTest.horizontal.expect', $form->__toString(TRUE));
    }

    public function testVertical()
    {
        $renderer = new Bs4VerticalFormRenderer();
        $form = $this->createFormWithRenderer($renderer);

        Assert::matchFile(__DIR__ . '/Bs4FormRendererTest.vertical.expect', $form->__toString(TRUE));
    }

    /**
     * @param IFormRenderer $renderer
     * @return Form
     */
    private function createFormWithRenderer(IFormRenderer $renderer): Form
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['name' => 'John Doe ', 'age' => '', 'email' => '  @ ', 'send' => 'on', 'street' => '', 'city' => '', 'country' => 'HU', 'password' => 'xxx', 'password2' => '', 'note' => '', 'submit1' => 'Send', 'userid' => '231'];

        $countries = [
            'Europe' => [
                'CZ' => 'Czech Republic',
                'SK' => 'Slovakia',
                'GB' => 'United Kingdom',
            ],
            'CA' => 'Canada',
            'US' => 'United States',
            '?' => 'other',
        ];
        $sex = [
            'm' => 'male',
            'f' => 'female',
        ];

        $form = new Form;
        $form->setRenderer($renderer);

        $form->addGroup('Personal data')
            ->setOption('description', 'We value your privacy and we ensure that the information you give to us will not be shared to other entities.')
            ->setOption('id', 'test-group-id-set-via-option');
        $form->addText('name', 'Your name:')
            ->addRule(Form::FILLED, 'Enter your name');
        $form->addInteger('age', 'Your age:')
            ->addRule(Form::FILLED, 'Enter your age')
            ->addRule(Form::RANGE, 'Age must be in range from %d to %d', [10, 100]);
        $form->addRadioList('gender', 'Your gender:', $sex);
        $form->addEmail('email', 'Email:')
            ->setEmptyValue('@');
        $form->addGroup('Shipping address')
            ->setOption('embedNext', TRUE);
        $form->addCheckbox('send', 'Ship to address')
            ->addCondition(Form::EQUAL, FALSE)
            ->elseCondition()
            ->toggle('sendBox');
        $form->addGroup()
            ->setOption('container', Html::el('div')->id('sendBox'));
        $form->addText('street', 'Street:');
        $form->addText('city', 'City:')
            ->addConditionOn($form['send'], Form::EQUAL, TRUE)
            ->addRule(Form::FILLED, 'Enter your shipping address');
        $form->addSelect('country', 'Country:', $countries)
            ->setPrompt('Select your country')
            ->addConditionOn($form['send'], Form::EQUAL, TRUE)
            ->addRule(Form::FILLED, 'Select your country');
        $form->addSelect('countrySetItems', 'Country:')
            ->setPrompt('Select your country')
            ->setItems($countries);
        $form->addGroup('Your account');
        $form->addPassword('password', 'Choose password:')
            ->addRule(Form::FILLED, 'Choose your password')
            ->addRule(Form::MIN_LENGTH, 'The password is too short: it must be at least %d characters', 3);
        $form->addPassword('password2', 'Reenter password:')
            ->addConditionOn($form['password'], Form::VALID)
            ->addRule(Form::FILLED, 'Reenter your password')
            ->addRule(Form::EQUAL, 'Passwords do not match', $form['password']);
        $form->addUpload('avatar', 'Picture:')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Uploaded file is not image');
        $form->addHidden('userid');
        $form->addTextArea('note', 'Comment:');
        $form->addButton('unset');
        unset($form['unset']);
        $form->addGroup();
        $form->addSubmit('submit', 'Send');
        $form->addButton('cancel', 'Cancel');
        $defaults = [
            'name' => 'John Doe',
            'userid' => 231,
            'country' => 'CZ',
        ];
        $form->setDefaults($defaults);
        $form->fireEvents();

        return $form;
    }
}

(new Bs4FormRendererTest())->run();