<?php
/**
 * Created by PhpStorm.
 * User: jasolar
 * Date: 19/09/18
 * Time: 09:58 AM
 */

// 7a83c151-6fc3-dc2b-b3a0-562a60aa3b74

global $current_user;


$viewdefs['Accounts']['base']['filter']['basic']['filters'][] = array(

    'id'=>'filterPromotorAccount',
    'name'=>'LBL_FILTER_PROMOTOR_ACCOUNTS',
    'filter_definition'=>array(

       '$or'=>array(

           array(
                    'user_id_c'=> array( // c57e811e-b81a-cde4-d6b4-5626c9961772
                            '$in'=> array($current_user->id),
                    ),
                ),
           array(
                    'user_id1_c'=> array( // a04540fc-e608-56a7-ad47-562a6078519d
                        '$in'=> array($current_user->id),
                    ),
                ),
           array(
               'user_id2_c'=> array( // '5d2205df-dac9-855d-5ceb-568d4035b952'
                   '$in'=> array($current_user->id),
               ),
           ),

       ),


    ),
    'editable'=>true,
    'is_template'=>true,
);
