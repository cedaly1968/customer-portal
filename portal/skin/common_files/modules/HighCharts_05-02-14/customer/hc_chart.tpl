<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script type="text/javascript">
//<![CDATA[

$(function () {ldelim}
       $('#container').highcharts({ldelim}
           {$cust_hchart.chart_setting}
        {rdelim});
   {rdelim});
//]]>
</script>

<script src={$SkinDir}/modules/HighCharts/customer/js/highcharts.js></script>
<script src={$SkinDir}/modules/HighCharts/customer/js/modules/exporting.js></script>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>