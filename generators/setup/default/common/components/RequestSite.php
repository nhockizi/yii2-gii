<?php
	echo '<?php
namespace common\components;

class RequestSite extends \yii\web\Request {
    public $web;
    public $Url;

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