function generate(name, tableId) {
    var tbl = document.getElementById(tableId);
    var opt = {
        filename: name,
    };
    html2pdf().set(opt).from(tbl).save();
}