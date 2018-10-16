//index.js

const util = require('../../utils/util.js');

//获取应用实例
const app = getApp()

Page({
  data: {
    motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    value: '',
    line_list: ''
  },
  //事件处理函数
  bindViewTap: function () {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    console.log(util.apiUrl);
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse) {
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
  },
  getUserInfo: function (e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  },
  onChange(e) {
		console.log('onChange', e.detail.value)
		this.setData({
			value: e.detail.value,
		})
	},
	onFocus(e) {
		console.log('onFocus', e)
	},
	onBlur(e) {
		console.log('onBlur', e)
	},
	onConfirm(e) {
    // console.log('onConfirm', e)
    wx.request({
      url: util.apiUrl+'lines.search', //仅为示例，并非真实的接口地址
      method: 'POST',
      data: {
        linename: e.detail.value
      },
      header: {
        // 'content-type': 'application/json' // 默认值
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: res =>{
        // console.log(res.data)
        this.setData({
          line_list: res.data.data
        })

      }
    })
	},
	onClear(e) {
		console.log('onClear', e)
		this.setData({
			value: '',
		})
	},
	onCancel(e) {
		console.log('onCancel', e)
  },
  getLine: function(e){
    console.log(e);
    wx.navigateTo({
      url: '../getline/getline?lineid='+e.currentTarget.dataset.line
    })
  }
})
