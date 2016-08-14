<?php
	echo '<?php
namespace common\components;

class RequestAdmin extends \yii\web\Request {
    public $web;
    public $Url = "/admin";

    public function getBaseUrl(){
        return str_replace($this->web, "", parent::getBaseUrl()) . $this->Url;
    }
    public function resolvePathInfo(){
        if($this->getUrl() === $this->Url){
            return "";
        }else{
            return parent::resolvePathInfo();
        }
    }
}';
?>