document.addEventListener("DOMContentLoaded", function() {
    var fosSubmit = document.querySelector('#SEND');
    fosSubmit.addEventListener('click', function (event) {
        var fos = document.forms["fos"];
        var all_fos_data = new FormData(fos);
        BX.ajax.runComponentAction("test:feedback.form", "save", {
            mode: "class",
            data: all_fos_data
        }).then(function (data) {
            location.href = '/test.php';
        }).catch(function (responseErrors) {
            responseErrors.data.forEach(function (elem) {
            });
        });
    });
});