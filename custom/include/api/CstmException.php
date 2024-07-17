<?php

require_once 'include/api/SugarApiException.php';

class CstmException extends SugarApiException{
    public $httpCode = 424;
    public $errorLabel = 'error_account_block';
    public $messageLabel = 'CSTM_EXCEPTION_LABEL';
}