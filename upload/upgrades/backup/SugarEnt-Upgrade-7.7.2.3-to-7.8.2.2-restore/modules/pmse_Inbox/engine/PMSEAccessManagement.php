<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

session_start();
require_once 'modules/pmse_Inbox/engine/PMSELicenseManager.php';
class PMSEAccessManagement {
    protected  $licM;
    protected  $objM=array();
    public     $kObj;
    protected $key;

    protected $expirationDate;
    protected $currentDate;
    protected $status;
    protected $type='LOOK';

    protected $defAcces='aGGjZXt5fmaIpYqLe2hoY4tjZouppGdjhHyVoZ+on5+Honpmm6mioZqmaKqYhXueYaxlimdkhmRpZYOYn6Keo2lhnqKgnmGdlWWVc6GVo6F8ZYpgoKGVlIiTopdpZItkdp6ee39ihXhkgGCsbpeeoZqJlGSfeGGZopWUqn9/aJ+YZqNohqKKpZ+hZqOik2WfmHyHiWaZpWKFdGadh3eTZnunnpdgrW55eaWikpNlp3x3inuppqmTm6WJoHZkoIN8pWWenoqTopZpZItnmoFhrG6JiaOcq6SbeYh7nWalf2OhiJGJZKRoYoR9laCcaZ2Ump5+ZKGTZYhmmaVihXhkgGGsd2KRZpNoeaeSh5GmnZZpZqd8nYl7qaapk5uliZx2ZKCDfKVlnpaKk6KWaWSLZ3SBYaxhimZleJeUYpt3hqKTiImnol+gnWOdlqqIhZWimXZkpZOBpGSdfJ2UmpGgnaCAoaGhe2epgHV/oYd8d5dgrWGgkWd/iKRlg3uSimWSk2SbeHeHeKKUqpWXpIekkZ6fooOVY5aDopSdeGWfl4iin2amlZuZk6Wghnx2l2KsbW6npqlbfaWemmibe5d+lIiSf2SpW3ynYHd/oIJ8k6Bgmn2ndH2TqIqSomWBaIqYf5WVZHZ8aJZmlX5ne1+fiWGsbm2nqGKlZ6WccqKpmJeko32bameDgIukg56joXKfpKapc6Gid5pqqn18o6KgmmqrknihlJmdf2SgiZKVeZZ8qnunnpNirG1umKhhdHylpZqjqXV7oqugmqWifppqaIN/i6WDnaShcZ5qo6mqZ6Vke3yqiatpYn58oqKhmmmrkniglZmdf2SgiWeVeZZoqHx1Y5JirXx4o6R4iIidln1pYJ6aommHonqplXN7notiomKDlmmlZ6VqYJl1kZdmlGmke2iTnYuFpaWTfHiVYqxtlJGocqpnpJ6apWZ7c6Njl5qkq5yZiqWUc3ydeJZ8ZpSWamCKk5WoeXmVYIN3iZV5lmelkV9mqoB5pGaJYGKWYK2rf32oaKlmo4SZfmN9dZVgnHehp5V0e514hKJllHSUYXWafWOIZ4uXZZVopWKaap6Un2pkZnRkkmGtcV+jp3KfoZNzhIBgf3VoZoWIoKaVc3udiXd9Zpp8paRyeWmqiKOLl2WVaaR4hZSfmZNpqIZfYpRhrG6FfKSpgGOcnnSUqHiifWBzkaOqeHhpYXinpaCBdKKdnaKgl3mbfaB7m6SnoKJ9qpuhpKiWhICqaGVkl2V/k2J6Z2SpfmRoZXx4eIlgrZ6ao6Jyq3yheZZmYX15pKGdiHqeYGJ7n4qZZaJ6X5RifaZnon94f2CBeImVeZZ8pn5keWJ6eJSmgHyelWA=';
    protected $keyPrimary='1001100110101001001001000';
    protected $getAcces=array();
    public $licLevel;
    protected $keyCook='opqck5KhzIqWgomRfKSWnJ+2lpSNfKaag6mrkpWC';
    public function __construct()
    {
        if(!($_SESSION['serial']))
        {
            $this->licM = new PMSELicenseManager();
            $this->objM  = $this->licM->getActiveLicenseData();
            $_SESSION['serial']=$this->closeLicence($this->objM);
        }
        else
        {
            if(!$this->_GETparams($_SESSION['serial'],sha1($this->keyPrimary)))
            {
                unset($_SESSION['serial']);
                $this->licM = new PMSELicenseManager();
                $this->objM  = $this->licM->getActiveLicenseData();
                $_SESSION['serial']=$this->closeLicence($this->objM);
            }
        }
        $this->currentDate=date('Y-m-d H:i:s');
    }
    public function closeLicence($obj)
    {
        $a001='';
        $a002='';
        foreach($obj as $ObjTab => $objVal)
        {
            $a001.=$ObjTab.',';
            $a002.=$objVal.',';
        }
        return $this->_SETparams(substr($a001,0,strlen($a001)-1).'|'.substr($a002,0,strlen($a002)-1),sha1($this->keyPrimary));
    }
    public function openLicence()
    {
        $valU=$this->_GETparams($_SESSION['serial'],sha1($this->keyPrimary));
        $valU=explode('|',$valU);
        $val001=explode(',',$valU[0]);
        $val002=explode(',',$valU[1]);
        if($val001)
        {
            for($i=0;$i<count($val001);$i++)
            {
                if($val001[$i]=='lic_product_expiration_date')
                {
                    $this->expirationDate=date("Y-m-d H:i:s", strtotime($val002[$i]));
                    $this->type='PRO';//ENT|PRO only for test erase
                }
                if($val001[$i]=='pmse_plan')
                {
                    $this->type = $val002[$i];

                }
            }
            $this->status = 'ACTIVE';
            return true;
        }
        else
        {
            return false;
        }
    }
    public function expirationKey()
    {
        if($this->openLicence())
        {
            $datetime1 = new DateTime($this->currentDate);
            $datetime2 = new DateTime($this->expirationDate);
            $interval = $datetime1->diff($datetime2);
            $request = $interval->format('%R%a dias');
            $request=substr($request,0,1);
            if($request=='+' || $request=='0')
            {
                return true;
            }
            elseif($request=='-')
            {
                return false;
            }
        }
        else{
            return false;
        }
    }
//new function
    public function licEventLook()
    {
        $tipo=$this->type;
        $k=0;
        $this->keyCook=base64_decode($this->keyCook);
        $auxArr=explode('|',$this->keyCook);

        foreach($auxArr as $val)
        {
            $result = '';
            for($i=0; $i<strlen($val); $i++) {
                $char = substr($val, $i, 1);
                $keychar = substr($tipo, ($i % strlen($tipo))-1, 1);
                $char = chr(ord($char)-ord($keychar));
                $result.=$char;
            }
            $auxArr[$k++]=base64_decode($result);
        }
        $this->keyCook=$auxArr;
        foreach($this->keyCook as $key)
        {
            $aux=explode('|',$key);
            if($aux[0]==$this->type &&  $aux[1]==0)
            {
                return true;
            }
            elseif($aux[0]==$this->type)
            {
                $this->licLevel=$aux[1];
                return false;
            }
        }
    }
    //function reader
    public function readerKey()
    {//function to analyze
        $i=0;
        $this->defAcces=explode('|',$this->_GETparams($this->defAcces,$this->keyPrimary));
        foreach($this->defAcces as $val)
        {
            if($this->licLevel <= substr($val,0,1))
            {
                $this->getAcces[$i++]=substr($val,1,strlen($val)-1);
            }
        }
        return $this->getAcces;
    }
    public function _SETparams($cad,$key)
    {
        $result = '';
        for($i=0; $i<strlen($cad); $i++) {
            $char = substr($cad, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
        return base64_encode(strrev($result));
    }
    public function _GETparams($txt,$tkt)
    {
        $result = '';
        $string = strrev(base64_decode($txt));
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($tkt, ($i % strlen($tkt))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }
    public function getAccesLicenced()
    {
        $this->key = '1234567890';
        return $this->readerKey();
    }
}

class lookLicenced
{
    public function look($actionEvent)
    {
        $openLic=new PMSEAccessManagement();
        $open=$openLic->expirationKey();
        $openAux=$openLic->licEventLook();
        if($open && $openAux)
        {
            return true;
        }
        else
        {
            if($actionEvent && $open)
            {
                $License=$openLic->readerKey();
                foreach($License as $val)
                {
                    $var=$openLic->_GETparams($val,$actionEvent);
                    $var=explode('|',$var);
                    $var=explode(',',$var[1]);
                    if($actionEvent==$var[1] && $open)
                    {
                        return true;
                    }
                }
                return false;
            }
            else
            {
                return false;
            }
        }
    }
}
//require_once 'modules/pmse_Inbox/engine/PMSEAccessManagement.php';
//this get licenced estate, with $var=lookLicenced::look('Event14');
