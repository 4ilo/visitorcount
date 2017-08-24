
var colors = ["rgba(217,83,79,", "rgba(66,139,202,", "rgba(208,209,2,", "rgba(215,0,96,", "rbga(92,184,92,", "rgba(255,99,132,","rgba(54, 162, 235,", "rgba(255, 206, 86,", "rgba(75, 192, 192,", "rgba(153, 102, 255,", "rgba(255, 159, 64,"];

$(document).ready(function () {
    var canvas = $("#mychart");
    var graphData;
    var datasetValue = [];

    $.get("visitorcount/graphdata", function (data, status) {
        if(status == "success")     // We hebben via ajax de data opgehaald, nu gaan we deze verwerken
        {
            // Voor elk jaar moeten we een dataset maken
            for(var i=0; i < data.length; i++)
            {
                if(i <= colors.length)
                {
                    color = colors[i];
                }
                else
                {
                    color = "rgba(215,0,96,";
                }

                datasetValue[i] = {
                    label: data[i]["jaar"],
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: color + "0.4)",
                    borderColor: color +"1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: color +"1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: color +"1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: data[i]["data"],
                    spanGaps: false,
                }
            }

            console.log(datasetValue);

            /* De data samen met de labels voor op de x-as */
            graphData = {
                labels: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli","Augustus","September","Oktober","November","December"],
                datasets: datasetValue,
            };

            // We maken een chart object gelinkt aan het html canvas
            var mychart = new Chart(canvas, { type: "line", data: graphData });
        }
    });

});