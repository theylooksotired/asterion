<?php
class Db_ObjectType {

    /*
    Available types:
        id-autoincrement
        id-char32
        id-varchar
        text
        text-small
        text-large
        text-postalcode
        text-telephone
        text-integer
        text-double
        text-number
        text-email
        text-unchangeable
        hidden
        hidden-url
        hidden-login
        hidden-integer
        hidden-user
        password
        textarea
        textarea-small
        textarea-large
        textarea-ck
        select
        date
        date-complete
        date-hour
        date-text
        checkbox
        radio
        point
        file
        multiple-object
        multiple-checkbox
        linkid-autoincrement
        linkid-char32
        linkid-varchar
    */

    static public function createTableSql($item) {
        $sql = '';
        $name = (string)$item->name;
        $type = (string)$item->type;
        switch (Db_ObjectType::baseType($type)) {
            default:
                if ((string)$item->lang == 'true') {
                    foreach (Lang::langs() as $lang) {
                        $sql .= '`'.$name.'_'.$lang.'` VARCHAR(255) COLLATE utf8_unicode_ci,';
                    }
                } else {
                    $sql .= '`'.$name.'` VARCHAR(255) COLLATE utf8_unicode_ci,';
                }
            break;
            case 'id':
                switch ($type) {
                    default:
                        $sql .= '`'.$name.'` INT NOT NULL AUTO_INCREMENT,';
                    break;
                    case 'id-char32':
                        $sql .= '`'.$name.'` CHAR(32) NOT NULL COLLATE utf8_unicode_ci,';
                    break;
                    case 'id-varchar':
                        $sql .= '`'.$name.'` VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci,';
                    break;
                }
                $sql .= 'PRIMARY KEY (`'.$name.'`),';
            break;
            case 'linkid':
                switch ($type) {
                    default:
                        $sql .= '`'.$name.'` INT NULL,';
                    break;
                    case 'linkid-char32':
                        $sql .= '`'.$name.'` CHAR(32) NULL COLLATE utf8_unicode_ci,';
                    break;
                    case 'linkid-varchar':
                        $sql .= '`'.$name.'` VARCHAR(255) NULL COLLATE utf8_unicode_ci,';
                    break;
                }
            break;
            case 'textarea':
                if ((string)$item->lang == 'true') {
                    foreach (Lang::langs() as $lang) {
                        $sql .= '`'.$name.'_'.$lang.'` TEXT COLLATE utf8_unicode_ci,';
                    }
                } else {
                    $sql .= '`'.$name.'` TEXT COLLATE utf8_unicode_ci,';
                }
            break;
            case 'select':
            case 'checkbox':
            case 'radio':
                $sql .= '`'.$name.'` INT,';
            break;
            case 'date':
                $sql .= '`'.$name.'` DATETIME,';
            break;
            case 'point':
                $sql .= '`'.$name.'` POINT NULL,';
            break;
            case 'multiple':
            break;
        }
        return $sql;
    }

    static public function baseType($type) {
        if (strpos($type, '-')!==false) {
            $typeInfo = explode('-', $type);
            return $typeInfo[0];
        }
        return $type;
    }

}
?>