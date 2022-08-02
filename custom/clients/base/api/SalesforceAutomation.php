<?php
    /**
     * Created by www.Levementum.com
     * User: jgarcia@levementum.com
     * Date: 7/27/2015
     * Time: 2:35 PM
     */
    if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
    require_once('custom/Levementum/SFA_Helper.php');

    class SalesforceAutomation extends SugarApi
    {
        public $dashlet_rows;
        public $subordinados;
        public $user_ids = Array();
        public $subordinado_ids = Array();

        public function registerApiRest()
        {
            return array(
                    'POSTSalesforceAutomation' => array(
                            'reqType' => 'POST',
                            'path' => array('SalesforceAutomation'),
                            'pathVars' => array(''),
                            'method' => 'getSalesforceAutomation',
                            'shortHelp' => 'Dashlet de Salesforce Automation',
                    ),

                    'POSTC2_Dashlet' => array(
                            'reqType' => 'POST',
                            'path' => array('C2Dashlet'),
                            'pathVars' => array(''),
                            'method' => 'getC2DashletData',
                            'shortHelp' => 'C2 Dashlet Estado de Operaciones',
                    ),
            );
        }

        public function getChildren($children, $parent_id, $AcctOrden, $AcctOrdenBy) //recursion
        {
            $sfa_helper = new SFA_Helper();
            foreach ($children as $child) {
                $child['myOpps'] =  $sfa_helper->getCurrentUserAccountsC2($child['metadata']['id'], $AcctOrden, $AcctOrdenBy);
                $child['Totals'] =  $sfa_helper->getTotalsByPromotorC2(array(0 => $child['metadata']['id']));
                $this->subordinado_ids[] =  $child['metadata']['id'];
                $this->user_ids[] = $child['metadata']['id'];
                $child['parent'] = $parent_id;
                $this->dashlet_rows[$child['metadata']['id']] = $child;
                if (!empty($child['children'])) {
                    $this->getChildren($child['children'], $child['metadata']['id']);
                }
            }
        }

        public function getSalesforceAutomation($api, $args)
        {
            global $current_user;
            $user_director = new SFA_Helper();
            $sfa_helper = new SFA_Helper();
            $currentUserId = $current_user->id;
            $this->user_ids[] = $currentUserId;

            $clienteOrden = $args['data']['clienteOrden'];
            $BacklogOrden = $args['data']['BacklogOrden'];
            $PipelineOrden = $args['data']['PipelineOrden'];

            $treintaOrden = $args['data']['treintaOrden'];
            $sesentaOrden = $args['data']['sesentaOrden'];
            $noventaOrden = $args['data']['noventaOrden'];
            $noventaOrdenMas = $args['data']['noventaOrdenMas'];

            if ($BacklogOrden != null) {
                $AcctOrden = $BacklogOrden;
                $AcctOrdenBy = 'backlog';
            }

            if ($PipelineOrden != null) {
                $AcctOrden = $PipelineOrden;
                $AcctOrdenBy = 'pipeline';
            }

            if ($treintaOrden != null) {
                $AcctOrden = $treintaOrden;
                $AcctOrdenBy = 'treinta';
            }

            if ($sesentaOrden != null) {
                $AcctOrden = $sesentaOrden;
                $AcctOrdenBy = 'sesenta';
            }

            if ($noventaOrden != null) {
                $AcctOrden = $noventaOrden;
                $AcctOrdenBy = 'noventa';
            }

            if ($noventaOrdenMas != null) {
                $AcctOrden = $noventaOrdenMas;
                $AcctOrdenBy = 'noventamas';
            }

            if ($clienteOrden != null) {
                $AcctOrden = $clienteOrden;
                $AcctOrdenBy = 'cliente';
            }

            //Get current user operations (Opportunities)
            $this->dashlet_rows['myOpps'] = $sfa_helper->getCurrentUserAccounts($currentUserId, $AcctOrden, $AcctOrdenBy);
            
            //Get Subordinados
            foreach ($args['data']['subordinados'] as $index => $subordinado) {
                $this->subordinado_ids = Array();
                $subordinado['myOpps'] = $sfa_helper->getCurrentUserAccounts($subordinado['metadata']['id'], $AcctOrden, $AcctOrdenBy);
                $this->user_ids[] = $subordinado['metadata']['id'];
                $this->subordinado_ids[] = $subordinado['metadata']['id'];
                $this->dashlet_rows[$subordinado['metadata']['id']] = 'Placeholder';
                if (!empty($subordinado['children'])) {
                    $this->getChildren($subordinado['children'], $subordinado['metadata']['id'], $AcctOrden, $AcctOrdenBy);
                }
                $subordinado['Totals'] = $sfa_helper->getTotalsByPromotor($this->subordinado_ids, true);
                $this->dashlet_rows[$subordinado['metadata']['id']] = $subordinado;

            }

            $this->dashlet_rows['grandTotal'] = $sfa_helper->getGrandTotal($this->user_ids);

            return $this->dashlet_rows;
        }

        public function getC2DashletData($api, $args)
        {
            global $current_user;
            $user_director = new SFA_Helper();
            $sfa_helper = new SFA_Helper();
            $currentUserId = $current_user->id;
            $this->user_ids[] = $currentUserId;

            $clienteOrden = $args['data']['clienteOrden'];
            $BacklogOrden = $args['data']['BacklogOrden'];
            $PipelineOrden = $args['data']['PipelineOrden'];

            $treintaOrden = $args['data']['treintaOrden'];
            $sesentaOrden = $args['data']['sesentaOrden'];
            $noventaOrden = $args['data']['noventaOrden'];
            $noventaOrdenMas = $args['data']['noventaOrdenMas'];

            if ($BacklogOrden != null) {
                $AcctOrden = $BacklogOrden;
                $AcctOrdenBy = 'backlog';
            }

            if ($PipelineOrden != null) {
                $AcctOrden = $PipelineOrden;
                $AcctOrdenBy = 'pipeline';
            }

            if ($treintaOrden != null) {
                $AcctOrden = $treintaOrden;
                $AcctOrdenBy = 'treinta';
            }

            if ($sesentaOrden != null) {
                $AcctOrden = $sesentaOrden;
                $AcctOrdenBy = 'sesenta';
            }

            if ($noventaOrden != null) {
                $AcctOrden = $noventaOrden;
                $AcctOrdenBy = 'noventa';
            }

            if ($noventaOrdenMas != null) {
                $AcctOrden = $noventaOrdenMas;
                $AcctOrdenBy = 'noventamas';
            }

            if ($clienteOrden != null) {
                $AcctOrden = $clienteOrden;
                $AcctOrdenBy = 'cliente';
            }

            //Get current user operations (Opportunities)

            $this->dashlet_rows['myOpps'] = $sfa_helper->getCurrentUserAccountsC2($currentUserId, $AcctOrden, $AcctOrdenBy);
            
            //Get Subordinados
            foreach ($args['data']['subordinados'] as $index => $subordinado) {
                $this->subordinado_ids = Array();
                $subordinado['myOpps'] = $sfa_helper->getCurrentUserAccountsC2($subordinado['metadata']['id'], $AcctOrden, $AcctOrdenBy);
                $this->user_ids[] = $subordinado['metadata']['id'];
                $this->subordinado_ids[] = $subordinado['metadata']['id'];
                $this->dashlet_rows[$subordinado['metadata']['id']] = 'Placeholder';
                if (!empty($subordinado['children'])) {
                    $this->getChildren($subordinado['children'], $subordinado['metadata']['id'], $AcctOrden, $AcctOrdenBy);
                }
                $subordinado['Totals'] = $sfa_helper->getTotalsByPromotorC2($this->subordinado_ids, true);
                $this->dashlet_rows[$subordinado['metadata']['id']] = $subordinado;

            }

            $this->dashlet_rows['grandTotal'] = $sfa_helper->getGrandTotal($this->user_ids);

            return $this->dashlet_rows;
        }
    }