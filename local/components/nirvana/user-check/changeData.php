<? define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$value = $request->getPost("user");
global $USER;

if ($USER->isAdmin()) {
    if ($value['change'] == 'true') {
        $filter = array(
            "ID" => intval($value['id']),
        );

        $tmp = [];
        $select = [
            'UF_CHANGEDATA',
        ];
        $fileds = ['*'];
        $rsUsers = CUser::GetList(($by = "ID"), ($order = "desc"), $filter, array('SELECT' => $select));
        while ($arUser = $rsUsers->fetch()) {
            $tmp = $arUser;
        }
        $changesData = json_decode($tmp['UF_CHANGEDATA'], true);
        if (isset($changesData['PERSONAL_PHOTO'])) {
            $changesData['PERSONAL_PHOTO'] = [
                'name' => basename($changesData['PERSONAL_PHOTO']),
                'type' => getimagesize($_SERVER['DOCUMENT_ROOT'] . $changesData['PERSONAL_PHOTO'])['mime'],
                'tmp_name' => $_SERVER['DOCUMENT_ROOT'] . $changesData['PERSONAL_PHOTO'],
                'error' => 0,
                'size' => filesize($_SERVER['DOCUMENT_ROOT'] . $changesData['PERSONAL_PHOTO'])
            ];
        }


        $goodArr = [
            'Юрист',
            'Юрисконсульт',
            'Юрист представитель',
            'Юрист эксперт',
            'Адвокат'
        ];
        if (in_array($changesData['PERSONAL_PROFESSION'],$goodArr)){
            $done = true;
            foreach ($changesData as $key => $item){
                if (empty($item)){$done = false;}
            }
            if ($done){
                $userGroup = CUser::GetUserGroup(intval($value['id']));
                $changesData['GROUP_ID'] = array_merge($userGroup,[8]);
            }
        }


    }

    $changesData['UF_CHANGEDATA'] = '';

    $user = new CUser;
    if ($user->Update($value['id'], $changesData)) {
        $val['done'] = true;
        echo json_encode($val);
    } else {
        $val['error'] = $user->LAST_ERROR;
        echo json_encode($val);
    }
}