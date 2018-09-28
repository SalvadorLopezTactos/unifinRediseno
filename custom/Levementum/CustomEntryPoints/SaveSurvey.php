<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
        /**
         * User: AF
         * Date: 03/09/2018
         * Time: 10:10
         */

        $GLOBALS['log']->fatal('>>>>>>>Entro el Entrypoint SaveSurvey:');//-------------------------------------

        $answers=[];
        $resultado = 'Resultado de Encuesta:\n';
        $id_encuesta=$_GET['id_encuesta'];

        //$resultado = "777777777777";
        //$id_encuesta="b6b5c0d0-b2c4-11e8-982e-3035add3ad60";

        $questions [0]= "En terminos generales¿Qué tan satisfecho se encuentra con el asesor UNIFIN asignado?: ";
        $questions [1]= "¿Qué tan satisfecho se encuentra con la atención y el trato brindado por el asesor?: ";
        $questions [2]= "¿Cómo calificaría al asesor con respecto al dominio del SECTOR al que pertenece su empresa / la empresa para la que trabaja?: ";
        $questions [3]= "¿Cómo calificaría al asesor con respecto al CONOCIMIENTO al que pertenece su empresa / la empresa para la que trabaja?: ";
        $questions [4]= "¿Qué tan satisfecho se encuentra con el conocimiento y la capacidad del asesor para resolver sus dudas?: ";
        $questions [5]= "En terminos generales¿Qué tan satisfecho se encuentra con el asesor UNIFIN asignado?: ";
        $questions [6]= "Despues de la cita con el asesor de UNIFIN usted diria que: ";

        for ($i=0;$i<count($questions);$i++) {
           // if($_POST["rq" . ($i + 1)]!='') {
                $answers[$i] = $_POST["rq" . ($i + 1)];
                $resultado .= $questions[$i] . $answers[$i] . '\n';
           // }

        }



        //echo "<script languaje='javascript' type='text/javascript'>alert('Enviando Encuesta....esta ventana se cerrara automaticamente, por favor espere');</script>";
        //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

        ?>

        <script>
            var id="<?php echo $id_encuesta;?>";
            var preguntas=<?php echo json_encode($questions);?>;
            var respuestas=<?php echo json_encode($answers);?>;
            var resultado="<?php echo $resultado;?>";
            var parametros=[id,preguntas,respuestas,resultado];
            var urlSugar='http://192.168.226.222:8888/unifin/rediseno';

               $.ajax({
                    type: 'post',
                    url: urlSugar + '/rest/v10/customSurvey',
                    data: {parametros},

                });

                alert('Encuesta enviada,Gracias!......');

                window.close();

        </script>
    </body>
</html>