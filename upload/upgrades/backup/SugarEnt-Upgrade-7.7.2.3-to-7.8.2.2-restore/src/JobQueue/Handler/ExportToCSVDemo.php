<?php
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

namespace Sugarcrm\Sugarcrm\JobQueue\Handler;


use Sugarcrm\Sugarcrm\JobQueue\Exception\LogicException;

require_once 'include/export_utils.php';

class ExportToCSVDemo implements RunnableInterface
{
    /**
     * @var string $module Module name.
     */
    protected $module;

    /**
     * @var array $data Of Ids.
     */
    protected $data;

    /**
     * @var string $file To write results.
     */
    protected $file;

    /**
     * @param string $module
     * @param string $data
     * @param string $file File name to append results.
     * @throws LogicException
     */
    public function __construct($module, $data, $file)
    {
        if (empty($data)) {
            throw new LogicException('Nothing to export.');
        }
        if (!file_exists($file)) {
            throw new LogicException('The file does not exist.');
        }
        $this->module = $module;
        $this->data = $data;
        $this->file = $file;
    }

    /**
     * Export records to CSV file and link with parent, if exists, or current job as a note record.
     * {@inheritdoc}
     */
    public function run()
    {
        $result = export($this->module, implode(',', $this->data));
        file_put_contents($this->file, $result, FILE_APPEND);

        return \SchedulersJob::JOB_SUCCESS;
    }
}
