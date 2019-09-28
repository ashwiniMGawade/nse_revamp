function exportTableToExcel (str) {
    var serverType = $("#export").attr('serverType');
    var urlParams = new URLSearchParams(location.search);
    var name = urlParams.get('name');
    var urlAppend = (name) ? "&name="+name : '';
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

     // Create download link element
     downloadLink = document.createElement("a");
    
     document.body.appendChild(downloadLink);

     downloadLink.href = 'index.php?p='+serverType+'&a=download'+urlAppend;

     downloadLink.download = "data_export_" + today + ".csv";

     //triggering the function
    downloadLink.click();
     
    //  if(navigator.msSaveOrOpenBlob){
    //      var blob = new Blob(['\ufeff', tableHTML], {
    //          type: dataType
    //      });
    //      navigator.msSaveOrOpenBlob( blob, filename);
    //  }else{
    //      // Create a link to the file
    //      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
     
    //      // Setting the file name
    //      downloadLink.download = filename;
         
    //      //triggering the function
    //      downloadLink.click();
    //  }

}