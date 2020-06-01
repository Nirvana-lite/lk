<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Page\Asset,
    Bitrix\Main\Context,
    Bitrix\Main\Request;

global $USER;
$request = Context::getCurrent()->getRequest();
$user_mail = ($USER->IsAuthorized()) ? $USER->GetEmail() : $request->getPost("user_mail");
$arResult['userMail'] = $user_mail;
Class SendClass{
    private $user;
    private $db;
    private $userMail;
    private $subCnt = 117358;
    function __construct()
    {
        global $USER,$DB;
        $this->user = $USER;
        $this->db = $DB;
    }
    function getAllSubs(){
        $tmp = [];
        $queryTmp = $this->db->Query("SELECT mail,sections FROM subs");
        while ($a = $queryTmp->fetch()){
            if ($a['sections'] == 'Y'){
                $tmp[] = $a['mail'];
            }
        }
        return $tmp;
    }
    function getCount(){
        $queryTmp = $this->db->Query("SELECT COUNT(*) FROM subs WHERE sections='Y'");
        $a = $queryTmp->fetch();
        return number_format($this->subCnt + $a['COUNT(*)'], 0, '', ' ');
    }
    function getSub($mail){
        $this->userMail = $mail;
        $queryTmp = $this->db->Query("SELECT sections FROM subs WHERE mail='{$mail}'");
        $a = $queryTmp->fetch();
        return $a;
    }
    function addNewSub(){
        $fields = [
            'mail' => "'{$this->userMail}'",
            'sections' => "'Y'"
        ];
        $this->db->PrepareFields("subs");
        $id = $this->db->Insert("subs", $fields);

        return (intval($id) > 0);
    }
    function addSub(){
        $fields = [
            'sections' => "'Y'"
        ];
        $this->db->PrepareFields("subs");
        $id = $this->db->Update("subs", $fields, "WHERE mail= '{$this->userMail}'");
        return $id;
    }
    function removeSub(){
        $fields = [
            'sections' => "'N'"
        ];
        $this->db->PrepareFields("subs");
        $id = $this->db->Update("subs", $fields, "WHERE mail= '{$this->userMail}'");
        return $id;
    }
}
$sendClass = new SendClass();
if ($request['change'] == 'Y'){
    $isSub = $sendClass->getSub($user_mail);
    if (!$isSub){
        $sendClass->addNewSub();
        $req['sub'] = true;
    }else{
        if ($isSub['sections'] == 'Y'){
            $sendClass->removeSub();
            $req['sub'] = false;
        }else{
            $sendClass->addSub();
            $req['sub'] = true;
        }
    }
    $req['cnt'] = $sendClass->getCount();
    echo json_encode($req);
}