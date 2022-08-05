<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\Authz\V1alpha;

/**
 * Service that implements the Authorization API
 */
class AuthzAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Authorize API request from access token.
     * @param \Sugarcrm\Apis\Iam\Authz\V1alpha\AuthorizeTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AuthorizeToken(\Sugarcrm\Apis\Iam\Authz\V1alpha\AuthorizeTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.authz.v1alpha.AuthzAPI/AuthorizeToken',
        $argument,
        ['\Sugarcrm\Apis\Iam\Authz\V1alpha\Authorization', 'decode'],
        $metadata, $options);
    }

}
