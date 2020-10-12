<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\Policy\V1alpha;

/**
 * Service that implements the Policy API
 */
class PolicyAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Sugarcrm\Apis\Iam\Policy\V1alpha\SetPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetPolicy(\Sugarcrm\Apis\Iam\Policy\V1alpha\SetPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.policy.v1alpha.PolicyAPI/SetPolicy',
        $argument,
        ['\Sugarcrm\Apis\Iam\Policy\V1alpha\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Sugarcrm\Apis\Iam\Policy\V1alpha\GetPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetPolicy(\Sugarcrm\Apis\Iam\Policy\V1alpha\GetPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.policy.v1alpha.PolicyAPI/GetPolicy',
        $argument,
        ['\Sugarcrm\Apis\Iam\Policy\V1alpha\Policy', 'decode'],
        $metadata, $options);
    }

}
