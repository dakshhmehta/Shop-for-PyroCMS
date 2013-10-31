$(window).load(function () 
{
    $.ajax({
        url: SITE_URL+'shop/admin/charts/stats/'+ CHART_SCOPE +'/30',
        dataType: 'json',
        success: buildGraph
    });
    $('.chart-data').click(function() 
    {
        $.ajax({
            url: $(this).attr('href'),
            dataType: 'json',
            success: buildGraph
        });
        $('.chart-tabs .tab-menu li').removeClass('ui-state-active');
        $(this).parent().addClass('ui-state-active');
        return false;
    });
});

var graph_data;

function buildGraph(result) 
{
    if (result == null)
    {
        result = graph_data;
    } 
    else
    {
        graph_data = result;
    }

    $.plot($('#chart_div'), result, {
        lines: {
            show: true
        },
        bars: {
            barWidth: 12,
            horizontal: false,
            align: "center",
            show: false,
            zero:true,
            fill:true,
            fillColor:'#000',
        },        
        points: {
            show: true,
            symbol: "circle"
        },
        grid: {
            hoverable: true, 
            backgroundColor: '#fefefe', /*backgroundColor: '#fefefe'*/
            borderColor: '#eee',
            borderWidth: 1,
            clickable: true
        },
        series: {
            lines: {
                show: true, 
                lineWidth: 1
            },
            shadowSize: 0
        },
        xaxis: {
            mode: "time"
        },
        yaxis: {
            min: 0
        },
        selection: {
            mode: "y"
        },

    });

     
    $("#chart_div").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
	 
        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;
						
                $("#tooltip").remove();
                var x = item.datapoint[0],
                y = item.datapoint[1];
						
                showTooltip(item.pageX, item.pageY,
                    item.series.label + " : " + y);
            }
        }
        else {
            $("#tooltip").fadeOut(500);
            previousPoint = null;            
        }
    });
}



// re-create the analytics graph on window resize
$(window).resize(function()
{
    buildGraph();
});
		
function showTooltip(x, y, contents) 
{
    $('<div id="tooltip">' + contents + '</div>').css( {
        position: 'absolute',
        display: 'none',
        top: y + 5,
        left: x + 5,
        'border-radius': '3px',
        '-moz-border-radius': '3px',
        '-webkit-border-radius': '3px',
        padding: '3px 8px 3px 8px',
        color: '#ffffff',
        background: '#000000',
        opacity: 0.80
    }).appendTo("body").fadeIn(500);
}
	 
var previousPoint = null;



