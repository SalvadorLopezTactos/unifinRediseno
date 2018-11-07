

    document.getElementById('filename_file').addEventListener("change", fileValidation);
    //document.getElementById('SAVE_HEADER').addEventListener("click", file_save); //No necesario

    function fileValidation() {
        console.log("Entro a fileValidation()");
        var fileInput = document.getElementById('filename_file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf|\.docx|\.doc|\.xlsx|\.xls)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('El archivo que estas intentando subir no cumple con los permitidos.');
            fileInput.value = '';
            return false;
        }
    }

    function file_save() {
        console.log("Entro a file_save()");
        var fileInput = document.getElementById('filename_file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf|\.docx|\.doc|\.xlsx|\.xls)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('El archivo que estas intentando guardar no cumple con los permitidos.');
            fileInput.value = '';
            return false;
        }
    }