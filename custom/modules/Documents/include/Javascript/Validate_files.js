

    document.getElementById('filename_file').addEventListener("change", fileValidation);
    //document.getElementById('SAVE_HEADER').addEventListener("click", file_save); //No necesario

    function fileValidation() {
        console.log("Entro a fileValidation()");
        var fileInput = document.getElementById('filename_file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.bmp|\.pdf|\.docx|\.doc|\.dot|\.xlsx|\.xls|\.pps|\.ppsx\.pptx|\.ppt|\.sldx)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('"El archivo que intentas adjuntar NO est\u00E1 permitido, favor de verificar.\n' +
                    'Archivos permitidos:\n' +
                    'Word\n' +
                    'Excel\n' +
                    'Power Point\n' +
                    'Imagenes\n' +
                    'PDF"');
            fileInput.value = '';
            return false;
        }
    }

