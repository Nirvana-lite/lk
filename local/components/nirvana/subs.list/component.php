<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("iblock");


Class SubsList{
    private $user;
    private $db;
    private $user_mail;
    function __construct()
    {
        global $USER,$DB;
        $this->user = $USER;
        $this->db = $DB;
        $this->user_mail = $this->user->GetEmail();
    }
    function findMail()
    {
        $queryTmp = $this->db->Query("SELECT id,sections FROM subs WHERE mail = '{$this->user_mail}'");
        return $queryTmp->fetch();
    }
    function getSubsList()
    {
        $tmp = $this->findMail();
        if (intval($tmp['id']) > 0){
            return json_decode($tmp['sections'],true);
        }else{
            return [];
        }
    }
}


    $sections = new SubsList();
    $subSections = $sections->getSubsList();
    /**
     * parent section code
     */
    $sectionCode = [
        17 => '/populyarnye-temy',
        21 => '/sotsialnye-programmy',
        24 => '/pravo-i-protsess',
        29 => '/vestnik-jur-portala',
    ];

    /**
     * get section tree list
     */
    $allList = [];
    $arFilter = array('IBLOCK_ID' => [17,21,24,29], 'ACTIVE' => 'Y');
    $arSelect = array('ID', 'NAME','IBLOCK_SECTION_ID','IBLOCK_ID',"CODE");
    $rsSection = CIBlockSection::GetList(Array("NAME"=>"ASC"),$arFilter,false, $arSelect);
    while($arSection = $rsSection->Fetch()) {
        if(intval($arSection['IBLOCK_SECTION_ID']) > 0){
            $code = "{$allList[$arSection['IBLOCK_SECTION_ID']]['code']}{$arSection['CODE']}";
        }else{
            $code = "{$sectionCode[$arSection['IBLOCK_ID']]}/{$arSection['CODE']}/";
        }

        $allList[$arSection['ID']] = [
            'id' => $arSection['ID'],
            'iblock' => $arSection['IBLOCK_ID'],
            'name' => $arSection['NAME'],
            'url' => $code,
            'mainName' => $arResult['all'][$arSection['IBLOCK_SECTION_ID']]['name'],
        ];
    }
    if (count($subSections) > 0){
        foreach ($allList as $list){
            if (in_array($list['id'],$subSections[$list['iblock']])){
                $arResult['sub'][] = $list;
            }
            else{
                $arResult['all'][] = $list;
            }
    }
    }else{
        $arResult['all'] = array_values($allList);
        $arResult['sub'] = [];
    }





$this->IncludeComponentTemplate();
?>