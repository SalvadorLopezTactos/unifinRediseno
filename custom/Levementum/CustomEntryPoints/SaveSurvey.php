<html>
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>
            window.jQuery || document.write('<script src="assets/jquery-3.3.1.min.js"><\/script>'))
        </script>
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
        $id_encuesta=$_GET['id_encuesta'];

        global $sugar_config;
        $GLOBALS['site_url'] = $sugar_config['site_url'];


        $questions [0]= "En terminos generales¿Qué tan satisfecho se encuentra con el asesor UNIFIN asignado?: ";
        $questions [1]= "¿Qué tan satisfecho se encuentra con la atención y el trato brindado por el asesor?: ";
        $questions [2]= "¿Cómo calificaría al asesor con respecto al dominio del SECTOR al que pertenece su empresa / la empresa para la que trabaja?: ";
        $questions [3]= "¿Cómo calificaría al asesor con respecto al CONOCIMIENTO al que pertenece su empresa / la empresa para la que trabaja?: ";
        $questions [4]= "¿Qué tan satisfecho se encuentra con el conocimiento y la capacidad del asesor para resolver sus dudas?: ";
        $questions [5]= "En terminos generales¿Qué tan satisfecho se encuentra con el asesor UNIFIN asignado?: ";
        $questions [6]= "Despues de la cita con el asesor de UNIFIN usted diria que: ";

        for ($i=0;$i<count($questions);$i++) {
            //if(isset($_POST["rq" . ($i + 1)])) {
                $answers[$i] = $_POST["rq" . ($i + 1)];
                $resultado .= $questions[$i] . $answers[$i] . '\n';
            //}

        }

        ?>

        <script>
            var id="<?php echo $id_encuesta;?>";
            var preguntas=<?php echo json_encode($questions);?>;
            var respuestas=<?php echo json_encode($answers);?>;
            var resultado="<?php echo $resultado;?>";
            var parametros=[id,preguntas,respuestas,resultado];
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

                });

                alert('Encuesta enviada,Gracias!......');
                window.close();

        </script>
    </body>
</html>
