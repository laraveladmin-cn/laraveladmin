<template>
    <div class="input-group">
        <div class="input-group-addon" v-if="random">
            <i class="fa fa-random" @click="randomVal"></i>
        </div>
        <input :type="type"
               v-model="password"
               :disabled="disabled"
               @blur="$emit('blur')"
               @keydown.enter="$emit('keydown-enter')"
               class="form-control"
               autocomplete="on"
               :placeholder="_placeholder">
        <div class="input-group-addon">
            <i class="fa fa-eye" v-show="type=='password'" @click="toggle"></i>
            <i class="fa fa-eye-slash" v-show="type!='password'" @click="toggle"></i>
        </div>
    </div>
</template>

<script>
    export default {
        name: "passwordEdit",
        props:{
            placeholder:{
                type:[String,Function],
                default: function () {
                    return 'Please enter';
                }
            },
            value:{
                default:function () {
                    return '';
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            },
            //随机生成密码
            random:{
                default: function () {
                    return false;
                }
            }
        },
        data(){
            return {
                password:this.value,
                type:'password'
            };
        },
        watch:{
            value(val){
                if(this.password!=val){
                    this.password = val;
                }
            },
            password(val){
                this.$emit('input', val); //修改值
                this.$emit('change',val); //修改值
            }
        },
        methods:{
            toggle(){
                this.type = this.type=='password'?'text':'password';
            },
            randomPass(len = 16, mode = "high"){
                const lowerCaseArr = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',];
                const blockLetterArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                const numberArr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                const specialArr = ['!', '@', '-', '_', '=', '<', '>', '#', '*', '%', '+', '&', '^', '$'];
                const passArr = [];
                let password = '';

                //指定参数随机获取一个字符
                const specifyRandom = function (...arr) {
                    let str = "";
                    arr.forEach(item => {
                        str += item[Math.floor(Math.random() * item.length)]
                    });
                    return str;
                }

                switch (mode) {
                    case "high":
                        //安全最高的
                        password += specifyRandom(lowerCaseArr, blockLetterArr, numberArr, specialArr);
                        passArr.push(...lowerCaseArr, ...blockLetterArr, ...numberArr, ...specialArr);
                        break;
                    case "medium":
                        //中等的
                        password += specifyRandom(lowerCaseArr, blockLetterArr, numberArr);
                        passArr.push(...lowerCaseArr, ...blockLetterArr, ...numberArr);
                        break;
                    //低等的
                    case "low":
                        password += specifyRandom(lowerCaseArr, numberArr);
                        passArr.push(...lowerCaseArr, ...numberArr);
                        break;
                    default:
                        password += specifyRandom(lowerCaseArr, numberArr);
                        passArr.push(...lowerCaseArr, ...numberArr);
                }

                const forLen = len - password.length;
                for (let i = 0; i < forLen; i++) {
                    password += specifyRandom(passArr);
                }

                return password;
            },
            randomVal(){
                this.password = this.randomPass(6,'low');
                this.type = 'text';

            }
        },
        computed:{
            _placeholder(){
                if(typeof this.placeholder=="function"){
                    return this.placeholder();
                }
                return this.$t(this.placeholder);
            }
        }
    }
</script>

<style scoped>

</style>
