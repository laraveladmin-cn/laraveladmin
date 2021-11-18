//用户数据存储
export default {
    namespaced: true,
    state:{
        user:{},
        loading:true //数据加载中
    },
    mutations:{
        //更新state状态
        set (state,payload) {
            state[payload.key] = payload[payload.key];
        }
    },
    actions:{
        //获取用户数据
        getUser({ state, commit, rootState },forced){
            if(state.user.id && !forced){
                return;
            }
            commit({
                type: 'set',
                key:'loading',
                loading: true
            });
            axios.get(rootState['use_url']+'/open/user').then(function (response) {
                if (typeof response.data != 'undefined' && typeof response.data.user != 'undefined') {
                    commit({
                        type: 'set',
                        key:'user',
                        user: response.data.user || {}
                    });
                    if(response.data.lifetime){
                        commit('set',{
                            key:'lifetime',
                            lifetime: response.data.lifetime
                        },{root:true});
                    }
                }
                commit({
                    type: 'set',
                    key:'loading',
                    loading: false
                });
            }).catch(function (error) {
                commit({
                    type: 'set',
                    key:'loading',
                    loading: false
                });
            });
        },
        //退出登录
        logout({ dispatch,state, commit, rootState }){
            let callback = function(){
                dispatch('refreshToken',null,{root:true}); //刷新token
                //清空用户数据
                commit({
                    type: 'set',
                    key:'user',
                    user: {}
                });
                setCookie('Authorization','',0);
            };
            axios.post(rootState['web_url']+'/open/logout',{_token:rootState._token}).then(function (response) {
                callback();
            }).catch(function (error) {
                if(error.response.status==302){
                    callback();
                }
            });
        }
    },
    getters:{
        //后台用户
        admin(state,getters){
            return state.user['admin'] || {};
        },
        //是否后台用户
        isAdmin(state,getters){
            return !!getters.admin['id'];
        },
        //后台用户角色
        roles(state,getters){
            return getters.admin['roles'] || [];
        },
        //角色名称
        roleName(state,getters){
            return window.array_get(getters.roles,'0.name' ,'');
        },
        //是否已经登录
        isLogined(state,getters){
            return !!state.user['id'];
        }
    }
};
