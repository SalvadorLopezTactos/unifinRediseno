<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

class CreatePayload
{

    /** @var WebLogicHook */
    private $current_hook;

    public function __construct(WebLogicHook $hook)
    {
        $this->current_hook = $hook;
    }

    /**
     * Convert linked beans to array using toArray() function
     * Remove nested beans
     *
     * @param Link2 $l
     * @return array
     */
    private function link2ToArray(Link2 $l): array
    {
        return array_map(
            function (SugarBean $bean) {
                /* convert bean to array and remove nested beans */
                return array_filter(
                    $bean->toArray(),
                    function ($value) {
                        return !($value instanceof Link2);
                    }
                );
            },
            $l->getBeans()
        );
    }

    /**
     * Decode html tags in data
     *
     * @param array $data
     * @return array
     */
    private function decodeHTML($data)
    {
        $returnData = [];

        $db = DBManagerFactory::getInstance();
        foreach ($data as $key => $value) {
            $returnData[$key] = $db->decodeHTML($value);
            if (is_array($value)) {
                $returnData[$key] = $this->decodeHTML($value);
            }
        }

        return $returnData;
    }

    /**
     * Create data to be serialized in JSON format
     *
     * @param SugarBean $bean
     * @param string $event
     * @param array $arguments
     * @return array
     */
    public function getPayload(SugarBean $bean, string $event, array $arguments) : array
    {
        global $current_user;

        $data = [];
        $sfh = new SugarFieldHandler();

        $result = [];
        $result['bean'] =  get_class($bean);

        if (isset($bean->id)) {
            $data['id'] = $bean->id;
        }

        if (!SugarACL::moduleSupportsACL($bean->webhook_target_module) || $bean->ACLAccess('detail')) {
            $fieldList = $bean->field_defs;

            $this->current_hook->ACLFilterFieldList($fieldList, ['bean' => $bean]);

            $service = new RestService();
            $service->user = $current_user;
            foreach ($fieldList as $fieldName => $properties) {
                $fieldType = !empty($properties['custom_type']) ? $properties['custom_type'] : $properties['type'];
                $field = $sfh->getSugarField($fieldType);
                if ('link' !== $fieldType && !empty($field) && (isset($bean->$fieldName)  || 'relate' === $fieldType)) {
                    $field->apiFormatField($data, $bean, array(), $fieldName, $properties, array(), $service);
                }
            }
        }

        /* All linked beans convert to array */
        $data_changes = array_map(
            function (array $field) {
                if ($field['data_type'] == 'link') {
                    if ($field['before'] instanceof Link2) {
                        $field['before'] = $this->link2ToArray($field['before']);
                    }
                    if ($field['after'] instanceof Link2) {
                        $field['after'] = $this->link2ToArray($field['after']);
                    }
                };
                return $field;
            },
            $arguments['dataChanges']
        );

        $result['data'] = $this->decodeHTML($data);
        $result['dataChanges'] = $this->decodeHTML($data_changes);
        $result['event'] = $event;

        return $result;
    }
}
