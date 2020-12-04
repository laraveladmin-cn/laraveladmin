//通知数据存储

export default {
    namespaced: true,
    state:{
        notifications:[]
    },
    mutations:{
        //更新state状态
        set (state,payload) {
            state[payload.key] = payload[payload.key];
        }
    },
    actions:{},
    getters:{}
};