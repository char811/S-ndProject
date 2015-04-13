
$(document).ready(function(){
    if ($('#chartdiv').length){
    var inputs = document.getElementsByTagName("input");
    for (var i=0; i<inputs.length;i++){
        var service= document.getElementsByTagName('input')[i].name;
        addEventListener("load", ajarx(service));
    } }
});

function ajarx(service){
    var data;
    $.ajax({
        url: 'chart',
        data: { service: service },
        success: function(orders) {
           return data=orders;
        },

    complete:
        function(data){
            var n=$.map(data.responseJSON,function(i){
                return i.service;
            });
            $(n).highcharts({
                chart: {
                    type: 'pyramid',
                    marginRight: 100
                },
                colors: ["#ff3831", "#0000ff", "#fff709", "#32cd32", "#aaeeee", "#ff0066", "#eeaaee",
                    "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
                title: {
                    text: '',
                    x: -50
                },
                plotOptions: {
                    pyramid: {
                        reversed:false,
                        depth: 300
                    },
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b> ({point.y:,.0f})',
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                            softConnector: true
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: 'Заявки',
                    data: $.map(data.responseJSON,function(i){
                        return [[i.name,i.data]];
                    })
                }]
            });
        }
    });
    return data;
}
