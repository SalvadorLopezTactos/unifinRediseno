<?php
    array_push($job_strings, 'seguros');

    function seguros()
    {
        //ECB 22/06/2023 Actualiza el estatus del producto de Seguros
		global $db;
		$query = "select accounts_uni_productos_1accounts_ida cuenta, accounts_uni_productos_1uni_productos_idb producto from accounts_uni_productos_1_c where deleted = 0 and accounts_uni_productos_1uni_productos_idb in (select a.id from uni_productos a, uni_productos_cstm b where a.id = b.id_c and a.deleted = 0 and a.tipo_producto = 10)";
		$results = $GLOBALS['db']->query($query);
		while($row = $GLOBALS['db']->fetchByAssoc($results)) {
			$cuenta = $row['cuenta'];
			$producto = $row['producto'];
			$query1 = "select a.id, a.date_modified from s_seguros a, s_seguros_cstm b where a.id = b.id_c and a.deleted = 0 and a.etapa <> 10 and b.inicio_vigencia_emitida_c <= CURDATE() and b.fin_vigencia_emitida_c >= CURDATE() and a.id in (select s_seguros_accountss_seguros_idb from s_seguros_accounts_c where deleted = 0 and s_seguros_accountsaccounts_ida = '$cuenta') order by a.date_modified desc";
			$resultado1 = $db->query($query1);
			$encontrado1 = $db->fetchByAssoc($resultado1);
			if($encontrado1) {
				$hoy = time();
				$mod = strtotime($encontrado1['date_modified']);
				$dias = $hoy - $mod;
				$dias = round($dias/(60*60*24));
				$update = "update uni_productos a, uni_productos_cstm b set a.estatus_atencion = 1, b.status_management_c = 1, b.dias_atraso_c = $dias where a.id = b.id_c and b.id_c = '$producto'";
			}
			else {
				$dias = 0;
				$atendido = 0;
				$query2 = "select a.id, a.date_modified from s_seguros a, s_seguros_cstm b where a.id = b.id_c and a.deleted = 0 and a.etapa <> 10 and a.id in (select s_seguros_accountss_seguros_idb from s_seguros_accounts_c where deleted = 0 and s_seguros_accountsaccounts_ida = '$cuenta') order by a.date_modified desc";
				$resultado2 = $db->query($query2);
				$encontrado2 = $db->fetchByAssoc($resultado2);
				if($encontrado2) {
					$hoy = time();
					$mod = strtotime($encontrado2['date_modified']);
					$dias = $hoy - $mod;
					$dias = round($dias/(60*60*24));
					if($dias < 90) $atendido = 1;
					else {
						$query3 = "select a.id, a.date_modified from meetings a, meetings_cstm b where a.id = b.id_c and a.deleted = 0 and b.asignado_producto_c = 'Leasing' and a.status = 'Held' and a.parent_id = '$cuenta' order by a.date_modified desc";
						$resultado3 = $db->query($query3);
						$encontrado3 = $db->fetchByAssoc($resultado3);
						if($encontrado3) {
							$hoy = time();
							$mod = strtotime($encontrado3['date_modified']);
							$dias = $hoy - $mod;
							$dias = round($dias/(60*60*24));
							if($dias < 90) $atendido = 1;
							else {
								$query4 = "select a.id, a.date_modified from calls a, calls_cstm b where a.id = b.id_c and a.deleted = 0 and b.asignado_producto_c = 'Leasing' and a.status = 'Held' and a.parent_id = '$cuenta' order by a.date_modified desc";
								$resultado4 = $db->query($query4);
								$encontrado4 = $db->fetchByAssoc($resultado4);
								if($encontrado4) {
									$hoy = time();
									$mod = strtotime($encontrado4['date_modified']);
									$dias = $hoy - $mod;
									$dias = round($dias/(60*60*24));
									if($dias < 90) $atendido = 1;
								}
							}
						}
						else {
							$query4 = "select a.id, a.date_modified from calls a, calls_cstm b where a.id = b.id_c and a.deleted = 0 and b.asignado_producto_c = 'Leasing' and a.status = 'Held' and a.parent_id = '$cuenta' order by a.date_modified desc";
							$resultado4 = $db->query($query4);
							$encontrado4 = $db->fetchByAssoc($resultado4);
							if($encontrado4) {
								$hoy = time();
								$mod = strtotime($encontrado4['date_modified']);
								$dias = $hoy - $mod;
								$dias = round($dias/(60*60*24));
								if($dias < 90) $atendido = 1;
							}
						}
					}
				}
				else {
					$query3 = "select a.id, a.date_modified from meetings a, meetings_cstm b where a.id = b.id_c and a.deleted = 0 and b.asignado_producto_c = 'Leasing' and a.status = 'Held' and a.parent_id = '$cuenta' order by a.date_modified desc";
					$resultado3 = $db->query($query3);
					$encontrado3 = $db->fetchByAssoc($resultado3);
					if($encontrado3) {
						$hoy = time();
						$mod = strtotime($encontrado3['date_modified']);
						$dias = $hoy - $mod;
						$dias = round($dias/(60*60*24));
						if($dias < 90) $atendido = 1;						
						else {
							$query4 = "select a.id, a.date_modified from calls a, calls_cstm b where a.id = b.id_c and a.deleted = 0 and b.asignado_producto_c = 'Leasing' and a.status = 'Held' and a.parent_id = '$cuenta' order by a.date_modified desc";
							$resultado4 = $db->query($query4);
							$encontrado4 = $db->fetchByAssoc($resultado4);
							if($encontrado4) {
								$hoy = time();
								$mod = strtotime($encontrado4['date_modified']);
								$dias = $hoy - $mod;
								$dias = round($dias/(60*60*24));
								if($dias < 90) $atendido = 1;
							}
						}
					}
					else {
						$query4 = "select a.id, a.date_modified from calls a, calls_cstm b where a.id = b.id_c and a.deleted = 0 and b.asignado_producto_c = 'Leasing' and a.status = 'Held' and a.parent_id = '$cuenta' order by a.date_modified desc";
						$resultado4 = $db->query($query4);
						$encontrado4 = $db->fetchByAssoc($resultado4);
						if($encontrado4) {
							$hoy = time();
							$mod = strtotime($encontrado4['date_modified']);
							$dias = $hoy - $mod;
							$dias = round($dias/(60*60*24));
							if($dias < 90) $atendido = 1;
						}
					}
				}
				if($atendido) $update = "update uni_productos a, uni_productos_cstm b set a.estatus_atencion = 1, b.status_management_c = 6, b.dias_atraso_c = $dias where a.id = b.id_c and b.id_c = '$producto'";
				else $update = "update uni_productos a, uni_productos_cstm b set a.estatus_atencion = 2, b.status_management_c = 6, b.dias_atraso_c = $dias where a.id = b.id_c and b.id_c = '$producto'";
			}
			$result = $db->query($update);
		}
        return true;
    }
