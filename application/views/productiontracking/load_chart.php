<?php
//print_r($expression)
?>
<script>
    var chart;
    var seriesOpts = [];
    var dlevel = 0;
    var index = 0;
    var my_title = '<?php echo "<b>PO:</b> " . $po->po_no . "<b>, Date: </b>" . date('d F Y', strtotime($po->date)) . ", <b>Vendor: </b>" . $po->vendor_name ?>';

    $.getJSON(base_url + 'productiontracking/get_summary_tracking_performance/<?php echo $po->id ?>', function (JSONResponse) {

        $(document).ready(function () {
            var categories = [];
            var data = [];
            var name = '';

            function setChart(name, categories, data, color) {
                chart.xAxis[0].setCategories(categories);
                chart.series[0].remove();
                chart.addSeries({
                    name: name,
                    data: data,
                    colorByPoint: true
                });
            }
            var colors = Highcharts.getOptions().colors;
            var index = 0;
            var chartdata = {
                name: 'project_progress',
                color: 0,
                level: 0,
                data: []
            };
            var options = {
                chart: {
                    renderTo: 'chart_content',
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: my_title
                },
                xAxis: {
                    categories: [],
                    minRange: 1,
                    title: {
                        text: 'Item List'
                    }, labels: {
                        rotation: -25,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    max: 100,
                    title: {
                        text: 'Progress %'
                    }
                },
                plotOptions: {
                    column: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {

                                    var drilldown = this.drilldown;
                                    if (drilldown) { // drill down
                                        this.series.chart.setTitle({
                                            text: drilldown.name
                                        });
                                        setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                    } else { // restore
                                        this.series.chart.setTitle({
                                            text: chart.name
                                        });
                                        setChart(name, categories, data);
                                    }
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            color: colors[0],
                            style: {
                                fontWeight: 'bold'
                            },
                            formatter: function () {
                                return this.y + ' %';
                            }
                        }
                    }
                },
                tooltip: {
                    formatter: function () {
                        var point = this.point;
                        var s = this.x + ': <b>' + this.y + ' % </b>';
                        if (point.drilldown) {
                            s = '' + point.category + ': <b>' + this.y + ' % ';
                        } else {
                            s += '';
                        }
                        return s;
                    }
                },
                series: [],
                exporting: {
                    enabled: false
                }
            };
            data = JSONResponse.data; //0-level data 
            name = JSONResponse.name; //0-level name
            categories = JSONResponse.categories; //0-level categories
            options.series.push(JSONResponse);
            options.xAxis.categories = categories;
            chart = new Highcharts.Chart(options);

        });
    });
</script>


