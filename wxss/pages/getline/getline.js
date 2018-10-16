
const util = require('../../utils/util.js');

Page({
    data: {
        lineid: ''
    },
    onLoad: function (options) {
        console.log(options);
        this.setData({
            lineid: options.lineid
        });


        // 线路信息
        wx.request({
            url: util.apiUrl + 'lines.getLineById', //仅为示例，并非真实的接口地址
            method: 'POST',
            data: {
                lineid: this.data.lineid
            },
            header: {
                // 'content-type': 'application/json' // 默认值
                'content-type': 'application/x-www-form-urlencoded'
            },
            success: res => {
                console.log(res.data)
                wx.setNavigationBarTitle({
                    title: res.data.data.LineName
                })


            }
        })

        //站点信息
        wx.request({
            url: util.apiUrl + 'lines.getStation', //仅为示例，并非真实的接口地址
            method: 'POST',
            data: {
                lineid: this.data.lineid
            },
            header: {
                // 'content-type': 'application/json' // 默认值
                'content-type': 'application/x-www-form-urlencoded'
            },
            success: res => {
                console.log(res.data)
                wx.setNavigationBarTitle({
                    title: res.data.data.LineName
                })


            }
        })

    }
})