<?php
namespace Bitrix\ListKeysTable;

use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\ORM\EntityError;
use Bitrix\Main\SystemException;


/**
 * Class KeysTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> CAT_ID int mandatory
 * <li> NAME string mandatory
 * <li> URL string mandatory
 * </ul>
 *
 * @package Bitrix\ListKeysTable
 **/

class KeysTable extends Main\Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'keyso_list_keys';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => 'ID',
            ),
            'CAT_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => 'CAT_ID',
            ),
            'NAME' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => 'NAME',
            ),
            'URL' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => 'URL',
            ),
            'ACTIVE' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => 'ACTIVE',
            ),
        );
    }
}

class KeysCategoryTable extends Main\Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'keyso_category';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'CAT_ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => 'CAT_ID',
            ),
            'NAME' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => 'NAME',
            ),
            'URL' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => 'URL',
            ),
        );
    }
}