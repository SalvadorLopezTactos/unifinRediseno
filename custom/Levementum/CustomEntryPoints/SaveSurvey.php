<html>
    <head>
<<<<<<< HEAD
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>
            window.jQuery || document.write('<script src="assets/jquery-3.3.1.min.js"><\/script>'))
        </script>
=======
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
>>>>>>> 43977a7c3fd403cd75b4edeab19569e01f7b5f2e
    </head>
    <body>
        <?php
        /**
         * User: AF
         * Date: 03/09/2018
         * Time: 10:10
         */

        $answers=[];
        $resultado = 'Resultado de Encuesta:\n';
<<<<<<< HEAD
        $id_encuesta=$_GET['id_encuesta'];

        global $sugar_config;
        $GLOBALS['site_url'] = $sugar_config['site_url'];

=======
        $id_reunion=$_GET['id_reunion'];

        //$resultado = "777777777777";
        //$id_reunion="b6b5c0d0-b2c4-11e8-982e-3035add3ad60";
>>>>>>> 43977a7c3fd403cd75b4edeab19569e01f7b5f2e

        $questions [0]= "En terminos generales¿Qué tan satisfecho se encuentra con el asesor UNIFIN asignado?: ";
        $questions [1]= "¿Qué tan satisfecho se encuentra con la atención y el trato brindado por el asesor?: ";
        $questions [2]= "¿Cómo calificaría al asesor con respecto al dominio del SECTOR al que pertenece su empresa / la empresa para la que trabaja?: ";
        $questions [3]= "¿Cómo calificaría al asesor con respecto al CONOCIMIENTO al que pertenece su empresa / la empresa para la que trabaja?: ";
        $questions [4]= "¿Qué tan satisfecho se encuentra con el conocimiento y la capacidad del asesor para resolver sus dudas?: ";
        $questions [5]= "En terminos generales¿Qué tan satisfecho se encuentra con el asesor UNIFIN asignado?: ";
        $questions [6]= "Despues de la cita con el asesor de UNIFIN usted diria que: ";

        for ($i=0;$i<count($questions);$i++) {
<<<<<<< HEAD
            //if(isset($_POST["rq" . ($i + 1)])) {
                $answers[$i] = $_POST["rq" . ($i + 1)];
                $resultado .= $questions[$i] . $answers[$i] . '\n';
            //}

        }

        ?>

        <script>
            var id="<?php echo $id_encuesta;?>";
=======
            if($_POST["rq" . ($i + 1)]!='') {
                $answers[$i] = $_POST["rq" . ($i + 1)];
                $resultado .= $questions[$i] . $answers[$i] . '\n';
            }

        }



        //echo "<script languaje='javascript' type='text/javascript'>alert('Enviando Encuesta....esta ventana se cerrara automaticamente, por favor espere');</script>";
        //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

        ?>

        <script>
            var id="<?php echo $id_reunion;?>";
>>>>>>> 43977a7c3fd403cd75b4edeab19569e01f7b5f2e
            var preguntas=<?php echo json_encode($questions);?>;
            var respuestas=<?php echo json_encode($answers);?>;
            var resultado="<?php echo $resultado;?>";
            var parametros=[id,preguntas,respuestas,resultado];
<<<<<<< HEAD
            var isIE = /*@cc_on!@*/false || !!document.documentMode;
            var urlSugar="http://<?php echo $_SERVER['SERVER_NAME'];?>/unifin"; //////Activar esta variable
            //var urlSugar="http://<?php echo $_SERVER['SERVER_NAME'];?>:8888/unifin/rediseno";

            if(isIE) {
                alert('Si se te muestra un mensaje acerca de ActiveX o Scripts, permite su ejecuci\u00F3n para el funcionamiento correcto de la encuesta');
            }

               $.ajax({
                    cache:false,
                    type: 'post',
                    url: urlSugar + '/rest/v10/customSurvey',
                    data: {parametros:parametros}
=======
            var urlSugar='http://192.168.226.222:8888/unifin/rediseno';

               $.ajax({
                    type: 'post',
                    url: urlSugar + '/rest/v10/customSurvey',
                    data: {parametros},
>>>>>>> 43977a7c3fd403cd75b4edeab19569e01f7b5f2e

                });

                alert('Encuesta enviada,Gracias!......');
<<<<<<< HEAD
=======

>>>>>>> 43977a7c3fd403cd75b4edeab19569e01f7b5f2e
                window.close();

        </script>
    </body>
</html>