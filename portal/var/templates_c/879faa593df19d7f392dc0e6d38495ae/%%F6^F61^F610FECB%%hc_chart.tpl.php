<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:43
         compiled from modules/HighCharts/customer/hc_chart.tpl */ ?>
<?php $_from = $this->_tpl_vars['hcquery_chart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chc'] => $this->_tpl_vars['cust_hchart']):
?> 
<script type="text/javascript">
//<![CDATA[
$(function () {
       $('#container_'+<?php echo $this->_tpl_vars['chc']; ?>
).highcharts({
           <?php echo $this->_tpl_vars['cust_hchart']['chart_setting']; ?>

        });
   });
//]]>
</script>

<div id="container_<?php echo $this->_tpl_vars['chc']; ?>
" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?php endforeach; endif; unset($_from); ?>
<script src=<?php echo $this->_tpl_vars['SkinDir']; ?>
/modules/HighCharts/customer/js/highcharts.js></script>
<script src=<?php echo $this->_tpl_vars['SkinDir']; ?>
/modules/HighCharts/customer/js/modules/exporting.js></script>