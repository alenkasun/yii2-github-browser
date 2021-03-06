<?php

namespace app\components;

use yii\base\Widget;
use Milo\Github\Api as GitHubApi;
use Milo\Github\OAuth\Token as MyToken;
use app\models\GithubUsers;

class UserWidget extends Widget{

    public $user;
    private $status;

    public function init (){
        parent::init();
        $api = new GitHubApi;
        //$token = new MyToken('833e3c356b24acecf75b52aa815ab48c82ad21ef');
        //$api->setToken($token);
        //$api->getToken();

     // contributors' info http://developer.github.com/v3/users/#get-a-single-user
        $this->user = $api->get('/users/:username',
                                    [
                                        'username' => $this->user
                                    ]
        );
        $this->user = (array)$api->decode($this->user);

     // define contributors' status
        $this->status = GithubUsers::find()->where(['id_user' => $this->user['id']])->one();
        $this->status = $this->status['status_user'];
    }

    public function run(){

        return $this->render(
            'user',
            [
                'user'   => $this->user,
                'status' => $this->status
            ]
        );

    }

}


?>


