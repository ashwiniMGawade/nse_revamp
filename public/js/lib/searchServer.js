function search (str) {
    if (str.length == 0) { 
        document.getElementById("search").innerHTML = "";
        return;
    } else {
        var serverType = $("#search").attr('serverType');
        $(".loader").show();
        $.ajax({
            url:"index.php", //the page containing php script
            type: "get", //request type,
            dataType: 'json',
            data: {search: str, p: serverType, a: "search"},
            success:function(result){
                $(".loader").hide();
                var html = "";
                if(result.length== 0) { 
                    html ="<li class='list-group-item'>No Records found</li>";
                } else {
                    result.forEach(row => {
                        html += '<a  class="list-group-item list-group-item-action" href="index.php?p='+serverType+'&a=server&name[]='+row['servername']+'"><li >'+row['servername']+'</li></a>';
                    });
                }
                document.getElementById("serverList").innerHTML = html;
            }
        });
    }
}