<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class TasksCest
{
    public function _before(AcceptanceTester $I)
    {
    }
    
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->wait(2);
        $I->see('My Application');
        $I->seeLink('Tasks');
        $I->wait(2);
        $I->click('Tasks');
        $I->see('Filter');
        $I->wait(2);
        $I->selectOption('Filter', 'June');
        $I->wait(2);
        $I->click('Find');
        $I->wait(2);
        $I->see('Название: Task 4');
        $I->wait(2);
        $I->click('Название: Task 4');
        $I->wait(2);
        $I->see('Login');
        $I->wait(2);
        $I->fillField('LoginForm[username]', 'admin');
        $I->wait(2);
        $I->fillField('LoginForm[password]', '123456');
        $I->wait(2);
        $I->submitForm(
            '#login-form',
            [
                'LoginForm' =>
                    [
                        'username' => 'admin',
                        'password' => '123456',
                        'login-button' => 'Login',
                    ]
            ]
        );
        $I->wait(2);
        $I->see('Comment');
        $I->wait(2);
        $I->fillField('Comments[comment]', 'Test success');
        $I->wait(2);
        $I->click('Добавить');
        $I->wait(5);
    }
}
