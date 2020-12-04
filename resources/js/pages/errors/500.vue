<template>
    <div class="error_500 error-page">
        <h2 class="headline text-red">500</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> 出错了! 服务器内部错误</h3>
            <p>
                服务器内部错误，请联系开发人员进行处理！你可以点击<a>首页</a>返回
            </p>
            <form class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="搜索">

                    <div class="input-group-btn">
                        <button type="button" name="submit"  class="btn btn-danger btn-flat">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
        },
    };
</script>
