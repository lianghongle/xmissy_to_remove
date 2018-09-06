<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="echarts" style="width: 600px;height:400px;"></div>

</div>

<script src="/plugins/echarts.js"></script>
<script>

    $(function(){
        $.ajax({
            'type':'GET',
            'url':'/fibos/get-exchange-info',
            'data': {
            },
            'dataType':'JSON',
            'success':function (res) {
                if(res.code == 0){
                    console.log(11)
                    if(res.data){
                        myEcharts('echarts', res.data)
                    }
                }else{
                    console.log('异常：' + res.code)
                }
            }
        });
    })

    function myEcharts(id, option)
    {
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById(id));

        // 指定图表的配置项和数据
        /*option = {
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                type: 'line'
            }]
        };*/

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    }
</script>