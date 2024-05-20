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
namespace Sugarcrm\Sugarcrm\DocumentMerge\Client\Constants;

abstract class MergeType
{
    const Merge = 'merge';
    const Convert = 'convert';
    const MultiMerge = 'multimerge';
    const MultiConvert = 'multimerge_convert';
    const LabelsGenerate = 'labelsgenerate';
    const LabelsGenerateConvert = 'labelsgenerate_convert';
    const Presentation = 'presentation';
    const PresentationConvert = 'presentation_convert';
    const Spreadsheet = 'excel';
    const SpreadsheetConvert = 'excel_convert';
}
