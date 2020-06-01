<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Page\Asset,
    Bitrix\Main\Context,
    Bitrix\Main\Request;
global $USER;

$request = Context::getCurrent()->getRequest();
$iblock_id =   $arParams['iblock_id'];
$section_id = $arParams['section_id'];

$user_mail = ($USER->IsAuthorized()) ? $USER->GetEmail() : $request->getPost("user_mail") ;

Class Subs{

    private $user_mail;
    private $iblock_id;
    private $section_id;
    private $user;
    private $DB;
    private $arr = [
        '17' => [1,2,3],
        '18' => [1,2,3],
        '19' => [1,2,3],
    ];
    function __construct($iblock_id,$section_id,$user_mail)
    {
        global $USER,$DB;
        $this->iblock_id = $iblock_id;
        $this->section_id = $section_id;
        $this->user_mail = $user_mail;
        $this->user = $USER;
        $this->DB = $DB;
    }

    function isUser(){
        $filter = ['EMAIL' => $this->user_mail];
        $sql = CUser::GetList(($by="personal_country"), ($order="desc"),$filter);
        return ($sql->NavNext(true, "f_"));
    }
    function findMail(){
      $queryTmp = $this->DB->Query("SELECT id,sections FROM subs WHERE mail = '{$this->user_mail}'");
      return $queryTmp->fetch();
    }
    function insertSection($sections){
        $fields = [
            'mail' => "'{$this->user_mail}'",
            'sections' => "'{$sections}'"
        ];
        $this->DB->PrepareFields("subs");
        $this->DB->Insert("subs", $fields);
    }
    function updateSections($sections){
        $fields = [
            'sections' => "'$sections'"
        ];
        $this->DB->PrepareFields("subs");
        $this->DB->Update("subs", $fields, "WHERE mail= '{$this->user_mail}'");
    }
    function changeSections($sections){
        $tmp = json_decode($sections,true);

        if (in_array($this->section_id,$tmp[$this->iblock_id])){
            $badKey = array_search($this->section_id,$tmp[$this->iblock_id]);
            /*echo json_encode($badKey);
            die();*/
            unset($tmp[$this->iblock_id][$badKey]);
            if (count($tmp[$this->iblock_id]) == 0){
                unset($tmp[$this->iblock_id]);
            }
        }else{
            $tmp[$this->iblock_id][] = $this->section_id;
        }
        /*echo json_encode($tmp);
        die();*/
        return json_encode($tmp);
    }
    function changeInfo(){
        $tmp = $this->findMail();
        if ($this->isUser()){
            if (intval($tmp['id']) > 0){
                $sections = $this->changeSections($tmp['sections']);
                $this->updateSections($sections);
            }else{
                $a[$this->iblock_id][] = $this->section_id;
                $sections = json_encode($a);
                $this->insertSection($sections);
            }
        }
        else{
            if (intval($tmp['id']) > 0){
                $this->updateSections('');
            }else{
                $this->insertSection(json_encode($this->arr));
            }
        }
    }
    function isSub(){
        $tmp = $this->findMail();
        $tmp = json_decode($tmp['sections'],true);
        return (in_array($this->section_id,$tmp[$this->iblock_id]));
    }

}

if ($request->getPost("change")){
    $sub = new Subs($iblock_id,$section_id,$user_mail);
    $sub->changeInfo();
    $arResult['isSub'] = $sub->isSub();
}else{
    $sub = new Subs($iblock_id,$section_id,$user_mail);
    $arResult['isSub'] = $sub->isSub();
}


$this->IncludeComponentTemplate();
?>