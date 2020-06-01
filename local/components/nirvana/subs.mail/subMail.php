<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$rsSites = CSite::GetByID(SITE_ID);
$arSite = $rsSites->Fetch();
$serverName = $arSite['SERVER_NAME'];
$siteName = $arSite['SITE_NAME'];
$siteMail = $arSite['EMAIL'];
?>
<?
$content = "
<table width='600px' cellspacing='0' cellpadding='0' style='margin: auto;'>
    <tbody>
    <tr>
        <td valign='top'>
            <!--header-->
            <table cellspacing='0' cellpadding='0' align='center' style='border: 3px solid #b5cbeb;'>
                <tbody>
                <tr>
                    <td align='center'>
                        <table width='600' cellspacing='0' cellpadding='0' bgcolor='#b5cbeb' align='center'>
                            <tbody>
                            <tr>
                                <td align='left'>
                                    <table width='100%' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                        <tr>
                                            <td width='600' valign='top' align='center'>
                                                <table width='100%' cellspacing='0' cellpadding='0'>
                                                    <tbody>
                                                    <tr>
                                                        <td align='left' style='padding:5px 15px;'>
                                                            <a target='_blank' href='#SERVER_NAME#' style='text-decoration: none; color:#222222; font-family:'>
                                                                #SITE_NAME#</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--end header--> <!--item-->
            <table cellspacing='0' cellpadding='0' align='center' style='background-color:#ffffff;border:3px solid #b5cbeb;'>
                <tbody>
                        $items
                <tr>
                    <td colspan='2' class='footer'>
                        <!--footer-->
                        <table cellpadding='0' cellspacing='0' align='center'>
                            <tbody>
                            <tr>
                                <td align='center' >
                                    <table width='600' cellspacing='0' cellpadding='0' align='center'>
                                        <tbody>
                                        <tr>
                                            <td  align='left'>
                                                <table width='100%' cellspacing='0' cellpadding='0'>
                                                    <tbody>
                                                    <tr>
                                                        <td width='560' valign='top' align='center'>
                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                <tbody>
                                                                <tr>
                                                                    <td align='center' style='font-size:0'>
                                                                        <table width='100%' height='100%' cellspacing='0' cellpadding='0'>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td style='border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;'>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center'>
                                                                        <small style='line-height: 100%;'>
                                                                            Спасибо и хорошего дня, <br>
                                                                            команда <b>#SITE_NAME#</b> <br>
                                                                            <b>8 800 777-32-63</b> <small>(По всей России)</small> <strong> <a target='_blank' href='mailto:#DEFAULT_EMAIL_FROM#' style='line-height: 150%;'>
                                                                                    #SERVER_NAME#</a> </strong> </small>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center'>
                                                                        <p>
                                                                            © 2020
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!--end footer-->
                    </td>
                </tr>
                </tbody>
            </table>
            <!--/item-->
        </td>
    </tr>
    </tbody>
</table>
";
?>

