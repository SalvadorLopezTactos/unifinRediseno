<?php
	/*Jesus Carrillo
	  Clase y metodo que agregan dash de radar a las nuevos usuarios que se crean
	*/
	class AgregaRadar{

		function agregardashboards($bean, $event, $arguments){
			$id=$bean->id;
			$puesto=$bean->puestousuario_c;
            //$GLOBALS['log']->fatal('>>>>>>>>Imprimiendo el valor de id:'.$id );
            //$GLOBALS['log']->fatal('>>>>>>>>Imprimiendo el valor de puesto:'.$puesto );
			$query="INSERT INTO `dashboards` (`id`,`name`,`date_entered`,`date_modified`,`modified_user_id`,`created_by`,`description`,`deleted`,`assigned_user_id`,`dashboard_module`,`view_name`,`metadata`) VALUES ('".$this->generaid()."','Mi radar','2018-08-03 14:18:29','2018-08-03 14:18:29','c57e811e-b81a-cde4-d6b4-5626c9961772','c57e811e-b81a-cde4-d6b4-5626c9961772',NULL,0,'".$id."','Home',NULL,'{\"components\":[{\"rows\":[[{\"width\":6,\"view\":{\"limit\":\"10\",\"date\":\"today\",\"visibility\":\"user\",\"label\":\"Calendario\",\"type\":\"planned-activities\",\"module\":null,\"template\":\"tabbed-dashlet\"}},{\"width\":6,\"view\":{\"label\":\"FEEDBACK\",\"type\":\"dashlet-Feedback\",\"module\":null}}],[{\"width\":12,\"context\":{\"module\":\"Home\"},\"view\":{\"url\":\"http:\\/\\/blog.lanyus.com\\/archives\\/326.html\",\"module\":\"Home\",\"limit\":3,\"label\":\"P\\u00e1gina Web\",\"type\":\"webpage\"}}]],\"width\":12}]}');";
            if($puesto==2 || $puesto==3 || $puesto==4 || $puesto==5 || $puesto==8 || $puesto==9 || $puesto==10 || $puesto==11 || $puesto==14 || $puesto==15 || $puesto==16 || $puesto==28 || $puesto==29 || $puesto==30) {
                $results = $GLOBALS['db']->query($query);
            }
       	}
        function generaid(){
            $b="";
            $b.=substr(md5(rand()), 0, 8)."-";
            $b.=substr(md5(rand()), 0, 4)."-";
            $b.=substr(md5(rand()), 0, 4)."-";
            $b.=substr(md5(rand()), 0, 4)."-";
            $b.=substr(md5(rand()), 0, 12);
            return $b;
        }
    }   
