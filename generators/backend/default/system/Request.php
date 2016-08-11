<?php
echo '<?php 
<?php
namespace common\components;


class Request extends \yii\web\Request {
    public $web;
    public $adminUrl = "/admin";

    public function getBaseUrl(){
        return str_replace($this->web, "", parent::getBaseUrl()) . $this->adminUrl;
    }
    public function resolvePathInfo(){
        if($this->getUrl() === $this->adminUrl){
            return "";
        }else{
            return parent::resolvePathInfo();
        }
    }
}';
?>