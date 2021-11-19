<?php
/**
 * @namespace Levementum
 * @file customGlobalSearchFields.php 
 * @author jescamilla@levementum.com 
 * @date 6/13/2015 5:18 PM
 * @brief 
 * @details 
 */

    $dictionary['Account']['fields']['rfc_c']['full_text_search']=array (
            'boost' => '3',
            'enabled' => true,
    );
    $dictionary['Account']['fields']['rfc_c']['unified_search']=true;